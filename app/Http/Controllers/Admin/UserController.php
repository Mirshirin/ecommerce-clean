<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\PasswordService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Contracts\RoleRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;




class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;
    protected $passwordService;
    public function __construct(
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository,
        PasswordService $passwordService
        )
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->passwordService = $passwordService;

       $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
       $this->middleware('permission:create-user', ['only' => ['create','store']]);
       $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
       $this->middleware('permission:delete-user', ['only' => ['destroy']]);
        
    }
    public function index(){
        
        $users = $this->userRepository->getAllUsers();  
        return view('admin.users.all-users',['users' => $users]);
    }
    public function show()
    {

        $users  = $this->userRepository->getAllUsers();
        return view('admin.users.all-users', ['users' => $users]);
       
    }
    public function create(){ 

        $roleNames = $this->roleRepository->getAllRoleNames(); 
      
        Log::info('Roles:', $roleNames);
       
        return view('admin.users.create-user',  [
            'roles' => $roleNames ,
         

        ]);   
       
    }
    
    
    public function store(StoreUserRequest $request)
    {  
  

        $validatedData = $request->validated(); 
        $user = app(UserRepositoryInterface::class)->store($validatedData);  
        
        if (!$user) {
            Log::warning('Failed to create user:', ['data' => $validatedData]);
            return back()->withErrors(['error' => 'Failed to create user.']);
        }
    
        if (method_exists($user, 'assignRole')) {
            foreach ($request->roles as $roleName) {
                Log::info('Entering assignRole'); 

                DB::table('model_has_roles')->insert([
                  
                    'role_id' => \Spatie\Permission\Models\Role::where('name', $roleName)->first()->id,
                    'model_type' => get_class($user),
                    'model_id' => $user->id,
                ]);
            }           

         
        } else {
            Log::warning('assignRole method not found on user object.');
        }  
        if (method_exists($user, 'syncPermissions')) {
            $permissions = DB::table("role_has_permissions")->where("role_id",\Spatie\Permission\Models\Role::where('name', $roleName)->first()->id)
            ->pluck('permission_id')
            ->all();
            
            foreach ($permissions as $permission) {
                Log::info('Assigning permission: ' .$permission);
        
             
                if ($permission) {
                    DB::table('model_has_permissions')->insert([
                        'permission_id' => $permission,
                        'model_type' => get_class($user),
                        'model_id' => $user->id,
                    ]);
                    Log::info('permission number: ' .$permission);
                    Log::info('model_id: ' .$user->id);
                } else {
                    Log::warning("Permission '{  $permissions}' not found.");
                }
            }
        }   

        return redirect(route('users.index'))->with('message','user was stored');
    }
    


    public function edit($id)
    {
            Log::info('Entering edit method'); // لاگ ورود به تابع
            
            $user = $this->userRepository->findUserById($id);
            Log::info('User fetched', ['user_id' => $user->id]); // لاگ دریافت اطلاعات کاربر
            
            // Check Only Super Admin can update his own Profile
            if ($user->hasRole('Super Admin')) {
                if($user->id != auth()->user()->id){
                    Log::warning('Permission denied', ['user_id' => $user->id, 'action' => 'edit']); // لاگ عدم دسترسی
                    abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONSsssssssssss');
                }
            }

            $roleNames = $this->roleRepository->getAllRoleNames();
            Log::info('Fetched role names'); // لاگ دریافت نام‌های نقش‌ها
            Log::info('Fetched role names',[ 'userRoles' => $user->roles->pluck('name')->all() ]); 
            Log::info('Fetched role names',[ 'userRoles' => $roleNames ]); 

         
            return view('admin.users.edit-user', [
                'roles' => $roleNames,
                'user' => $user,
                'userRoles' => $user->roles->pluck('name')->all()
            ]);
    
    }
    public function update(UpdateUserRequest $request,User $user)
    { 
 
        $user = User::findOrFail($user->id);   
           
        Log::info('Entering update method'); // Log entering the method
        $validatedData = $request->all(); 
       // $validatedData = $request->validated();  
       // Log::info('validated', $validatedData); // Log entering the method

        if ($request->has('verify') && !$user->hasVerifiedEmail())
        {
            Log::info('Marking email as verified', ['user_id' => $user->id]); // Log email verification
            $user->markEmailAsVerified();
        }


        // if (!empty($request->has('password'))) {
        //     // Hash the password
        //     $validatedData['password'] = $validatedData['password'];
        // }
        //Log::info('validated', $validatedData); // Log entering the method
        $user = app(UserRepositoryInterface::class)->update($validatedData,$user->id); 
        Log::info('update'); 
        if ($request->has('roles')) {
            $user->roles()->detach();
        if (method_exists($user, 'assignRole')) {
            foreach ($request->roles as $roleName) {
                Log::info('Entering $request->roles '); 

                DB::table('model_has_roles')->insert([
                    
                    'role_id' => \Spatie\Permission\Models\Role::where('name', $roleName)->first()->id,
                    'model_type' => get_class($user),
                    'model_id' => $user->id,
                ]);
            }            
           }               
        }
        Log::info('roles'); 
        session()->flash('success','h با موفقیت تغییر کرد');

        return redirect()->route('users.index')->with('message','user was updated.');
    //   } catch (\Exception $e){
    //     Log::info('catching '); 

    //     return redirect()->back()->withErrors(['error' => 'faield to update user, please try again later']);
    //   }
    }   

    public function destroy($id)
    {
        try {
             $user= $this->userRepository->findUserById($id);
       
            // if ($user->hasRole('Super Admin') )
            // {
            //      abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            // }
         
            $this->userRepository->destroy($user->id);
       
             return response()->json([ 'status' => 'User deleted successfully' ]);

        }catch(ModelNotFoundException $e){
             return response()->json(['status' => 'Failed to delete user'], 500);
      }
    }
   
    public function updatePassword(PasswordChangeRequest $request)
    {
      
        $data=$request->validated();        
        $user = Auth::user();

        if (!$this->passwordService->changePassword($user, $data['old_password'], $data['new_password'])) {
            return back()->with([
                'message' => 'Old password does not match!',
                'alert-type' => 'error'
            ]);
        }

        return redirect('admin/dashboard')->with([
            'message' => 'Password changed successfully!',
            'alert-type' => 'success'
        ]);
      
    }

    public function changePassword()
    {
        $user=Auth::user();            
        return view('admin.users.change-password',compact('user'));
    }
}
