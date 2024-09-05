

<header class="header_section">
    <div class="container">
       <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="{{ route('admin-dashboard') }}"><img width="250" src="{{ asset('/images/logo.png') }}" alt="#" /></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""> </span>
          </button>
          <div class=" navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav"> 
               <div>
                  @if(session('success'))
                     <div class="alert alert-success">
                           {{ session('success') }}
                     </div>
                  @endif  
               </div>  
                             
               <li class="nav-item dropdown">
                  <a class="nav-link" href="#about-the-page" >
                     About 
                  </a> 
               </li>
               @can(['view-product'])
                <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}#allproduct">
                Products
                  </a> 
                </li>              
                @endcan
               <div class="dropdown">
               <button id="dLabel" type="button"  class="dropdown-toggle" data-bs-toggle="dropdown"  style="margin-right: 10px;">     
               <i class="fa fa-shopping-cart" aria-hidden="true"></i>Cart <span class="badge bg-danger">{{ count((array) session('cart')) }}</span>
               </button>
             
                <div class="dropdown-menu" aria-labelledby="dLabel" >
                  <div class="row total-header-section">
                     @php $total=0 @endphp
                     @foreach((array) session('cart') as $id => $details)
                        @php $total+= $details['price'] * $details['quantity'] @endphp
                     @endforeach
                        <div class="col-lg-12 col-sm-12 col-12 total-section ">
                           <p> Total:   <span class="text-success">$ {{  $total }}</span></p>                      
                        </div>
                  </div>
                  @if(session('cart'))
                     @foreach((array) session('cart') as $id => $details)
                        <div class="row cart-detail">
                              <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                              <img src="{{ $details['image'] }}" >                              
                              </div>
                              <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                 <p>{{ $details['product_title'] }}</p>
                                 <span class="price text-success">${{ $details['price'] }}</span> <span class="count">Quantity: {{ $details['quantity'] }}</span>
                              </div>
                        </div>
                     @endforeach
                  @endif
                  <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12 total-center checkout">
                           <a  href="{{ route('show-carts') }}" class="btn btn-primary btn-block">View all</a>
                        </div>
                  </div>                  
                </div> 
                </div> 
                
                @if (Route::has('login'))
                <div >
                           @auth
                           <nav x-data="{ open: false }" >
                              <!-- Primary Navigation Menu -->
                              <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                 <div class="flex justify-between">
                                    
                                    <!-- Settings Dropdown -->
                                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                                          <x-dropdown align="right" width="48">
                                             <x-slot name="trigger">
                                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                      <div>{{ Auth::user()->name }}</div>
                        
                                                      <div class="ml-1">
                                                         <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                         </svg>
                                                      </div>

                                                </button>
                                             </x-slot>
                        
                                             <x-slot name="content">
                                                <x-dropdown-link :href="route('profile.edit')">
                                                      {{ __('Profile') }}
                                                </x-dropdown-link>
                                      
                                                <!-- <x-dropdown-link :href="route('password.update')">
                                                      {{ __('changpassword') }}
                                                </x-dropdown-link> -->
                                                <!-- Authentication -->
                                                <form method="POST" action="{{ route('logout') }}">
                                                      @csrf   
                     
                                                      <x-dropdown-link :href="route('logout')"
                                                            onclick="event.preventDefault();this.closest('form').submit();">
                                                         {{ __('Log Out') }}
                                                      </x-dropdown-link>

                                                </form>

                                             </x-slot>
                                          </x-dropdown>
                                    </div>
                        
                                    <!-- Hamburger -->
                                    <div class="-mr-2 flex items-center sm:hidden">
                                          <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                             <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                             </svg>
                                          </button>
                                    </div>
                                 </div>
                              </div>
                        
                              <!-- Responsive Navigation Menu -->
                              <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                                 
                        
                                 <!-- Responsive Settings Options -->
                                 <div class="pt-4 pb-1 border-t border-gray-200">
                                    <div class="px-4">
                                          <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                          <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                    </div>
                        
                                    <div class="mt-3 space-y-1">
                                          <x-responsive-nav-link :href="route('profile.edit')">
                                             {{ __('Profile') }}
                                          </x-responsive-nav-link>
                        
                                          <!-- Authentication -->
                                          <form method="POST" action="{{ route('logout') }}">
                                             @csrf
                        
                                             <x-responsive-nav-link :href="route('logout')"
                                                      onclick="event.preventDefault();
                                                                  this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                             </x-responsive-nav-link>
                                          </form>
                                    </div>
                                 </div>
                              </div>
                        </nav>
                        

                    @else

                    <div class="flex">
                           <li class="nav-item">
                              <a class="btn btn-info" href="{{ route('login') }}">Login</a>
                           </li>                     
                           @if (Route::has('register'))                        
                              <li class="nav-item">
                                 <a class="btn btn-success ml-1" href="{{ route('register') }}">Register</a>
                              </li>                           
                           @endif
                    </div>
                        
                    @endauth
                </div>
                @endif



             </ul>
          </div>
       </nav>
    </div>
 </header>