<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateUserRequest;
use App\Contracts\RoleRepositoryInterface;
use App\Contracts\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(UserRepositoryInterface $userRepository,RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;

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
        return view('admin.users.create-user',  ['roles' => $roleNames]);   
       
    }
    // public function store(StoreUserRequest $request){       
  
    //     $validatedData = $request->validated(); 
    //     $user = app(UserRepositoryInterface::class)->store($validatedData);  
    //     $user->assignRole($request->roles);      
    //     return redirect(route('users.index'))->with('message','user was stored');
    // }
    public function store(StoreUserRequest $request)
    {     
    
       // Log::info('Storing user...', ['request' => $request->all()]);
        
        $validatedData = $request->validated(); 
        $user = app(UserRepositoryInterface::class)->store($validatedData);  
        
        if (!$user) {
            Log::warning('Failed to create user:', ['data' => $validatedData]);
            return back()->withErrors(['error' => 'Failed to create user.']);
        }
    
        if (method_exists($user, 'assignRole')) {
            foreach ($request->roles as $roleName) {
               
                DB::table('model_has_roles')->insert([
                  
                    'role_id' => \Spatie\Permission\Models\Role::where('name', $roleName)->first()->id,
                    'model_type' => get_class($user),
                    'model_id' => $user->id,
                ]);
            }
            
         //  $user->assignRole($request->roles);
        } else {
            Log::warning('assignRole method not found on user object.');
        }
    
        return redirect(route('users.index'))->with('message','user was stored');
    }
    

    // public function edit($id)
    // {
        
    //     $user=$this->userRepository->findUserById($id);
    //     // Check Only Super Admin can update his own Profile
    //     if ($user->hasRole('Super Admin')){
    //         if($user->id != auth()->user()->id){
    //             abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
    //         }
    //     }
    //     $roleNames = $this->roleRepository->getAllRoleNames();
    //     return view('admin.users.edit-user',  [
    //         'roles' => $roleNames,
    //         'user' => $user,
    //         'userRoles' => $user->roles->pluck('name')->all(),
        
    //     ]);
    // }

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

            return view('admin.users.edit-user', [
                'roles' => $roleNames,
                'user' => $user,
                'userRoles' => $user->roles->pluck('name')->all()
            ]);
    
    }

    public function update(Request $request, $id)
    {    
      //  dd( $id);
        $validatedData = $request->validated();   
         
        $user = app(UserRepositoryInterface::class)->update($validatedData,$id);    
        Session::flash('statuscode','success');
        if ($request->has('verify'))
        {
            $user->markEmailAsVerified();
        }
        $user->syncRoles($request->roles);

       return redirect()->route('users.index')->with('message','user was updated.');
    }

    // public function update(UpdateUserRequest $request, $id)
    // {         
 
    //     Log::info('Entering update method'); // Log entering the method
        
    //     $validatedData = $request->validated();           
    //     Log::info('Validated data', ['data' => $validatedData]); // Log validated data
        
    //     $user = app(UserRepositoryInterface::class)->update($validatedData,$id);    
    //     Log::info('User updated', ['user_id' => $user->id]); // Log user update
        
    //     if ($request->has('verify'))
    //     {
    //         Log::info('Marking email as verified', ['user_id' => $user->id]); // Log email verification
    //         $user->markEmailAsVerified();
    //     }
        
    //     $user->syncRoles($request->roles);
    //     Log::info('Synced roles', ['user_id' => $user->id, 'roles' => $request->roles]); // Log role sync
      
    //     return redirect()->route('users.index')->with('message','user was updated.');
    // }

    public function destroy($id)
    {
            
       $user= $this->userRepository->destroy($id );
       if ($user->hasRole('Super Admin') )
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }
 
       if (! $user) {
        // Handle the case where the user was not found or could not be deleted
        return response()->json(['status' => 'Failed to delete user'], 500);
    }
     return response()->json([ 'status' => 'User deleted successfully' ]);
    }
   
    public function updatePassword(Request $request)
    {
      
        $data=$request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',

        ]);       
         /// Match the old passwword
         if (!Hash::check($request->old_password,auth()->user()->password)){
            $notification= array(
                'message' => 'old password does not match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
         } 
         //update new password  
         User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
         ]) ; 
         $notification= array(
            'message' => 'password change successfully!',
            'alert-type' => 'success'
        );  
       // return back()->with($notification);

       return redirect('admin/dashboard');
      
    }

    public function changePassword()
        {
            $id=auth()->user()->id;
            $user=User::find($id);
        return view('admin.users.change-password',compact('user'));
    }
}
