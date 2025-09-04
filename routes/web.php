<?php

use App\Http\Controllers\Admin\{CategorieController, DurationController, ExperienceController, RequestController, Service_Provider_ProjectsController, SiteSettingController, SkillController, UserController};
use App\Http\Controllers\Admin\Project_clientController;
use App\Http\Controllers\Service_provider\{DashboardController as Service_providerDashboardController, MyWorkController, ProfileServiceProviderController, ProjectController as Service_providerProjectController, ServiceController};
use App\Http\Controllers\Auth\{LoginController, RegisterController};
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Client\{ClientDashboardController, OfferController, ProjectController};
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\DisputeController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('victim', function () {
    return view('your_site');
});

Route::get('attacker_site', function () {
    return view('attacker_site');
});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['throttle:100,1', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::group([
            'controller' => LoginController::class,
        ], function () {
            Route::get('/', 'welcome')->name('home');
            Route::get('/login', 'index')->name('login.index');
            Route::get('/verification', 'verification')->name('verification');


            Route::middleware('guest')->group(function () {
                Route::post('/login/check', 'login')->middleware('throttle:5,1')->name('login');


                Route::get('/password', 'password')->name('password');

                Route::post('/forget_password', 'forget_password')->name('forget_password');
                Route::post('/change_password', 'change_password')->name('change.password');
                Route::post('/virfction_forget_password/check', 'virfction_password')->name('virfction_password');
            });

            Route::get('logout', 'logout')->middleware('auth')->name('logout');


            Route::group([
                'middleware' => ['auth'],
            ], function () {
                Route::post('/verification/check', 'check')->name('verification.check');
                
            });
        });


        Route::group([
            'controller' => RegisterController::class,
        ], function () {
            Route::middleware('guest')->group(function () {
                Route::get('/register', 'index')->name('register.index');
                Route::post('/register/check', 'create')->name('register');
            });
        });



        // admin
        Route::group(
            [
                'middleware' => ['auth', 'checkusertype:admin'],
                'prefix' => '/Admin'
            ],
            function () {
                Route::group([
                    'controller' => DashboardController::class,
                ], function () {
                    Route::get('/dashboard', 'index')->name('dashboard');
                });

                Route::group([
                    'controller' => ProfileController::class,
                ], function () {
                    Route::get('/profile', 'view')->name('profile.admin');
                    Route::post('/profile', 'update')->name('profile.admin.update');
                });

                Route::group([
                    'controller' => RequestController::class,
                ], function () {
                    Route::get('/request', 'index')->name('request.index');
                    Route::post('/request/enable/{id}', 'enable')->name('request.enable');
                    Route::post('/request/not_enable/{id}', 'not_enable')->name('request.not_enable');
                });

                Route::group([
                    'controller' => UserController::class,
                ], function () {
                    Route::get('/users/service_provider', 'service_provider')->name(name: 'user.service_provider');
                    Route::get('/users/client', 'client')->name('user.client');
                    Route::get('/users/service_provider/{id}', 'show')->name('users.show');
                    Route::post('/users/service_provider/delete/{id}', 'delete')->name('user.service_provider.delete');
                    Route::post('/users/service_provider/is_blocked/{id}', 'is_blocked')->name('user.service_provider.is_blocked');
                    Route::post('/users/service_provider/unblocked/{id}', 'unblocked')->name('user.service_provider.unblocked');
                });

                Route::group([
                    'controller' => Project_clientController::class
                ], function () {
                    Route::get('/projects', 'index')->name('admin.projects.index');
                    Route::get('/projects/show/{id}', 'show')->name('admin.projects.show');
                    Route::post('/categories/skills/{id}', 'skill');
                    Route::post('/search', 'search')->name('admin.project.search');
                });

                Route::group([
                    'controller' => SiteSettingController::class,
                    'prefix' => '/Site_Setting'
                ], function () {
                    Route::get('', 'index')->name('Site_Setting');
                    Route::POST('/update', 'update')->name('Site_Setting.update');
                });
                Route::group([
                    'controller' => DisputeController::class,
                    'prefix' => '/disputes',
                ], function () {
                    Route::get('', 'indexForAdmin')->name('admin.disputes');
                    Route::get('/{id}', 'showForAdmin')->name('admin.disputes.show');
                    Route::post('/{dispute}/resolve', 'resolve')->name('admin.disputes.resolve');
                });

                Route::group([
                    'controller' => TransactionController::class,
                    'prefix' => '/transactions',
                ], function () {
                    Route::get('/', 'indexForAdmin')->name('admin.transactions');
                    Route::get('/{transaction}', 'show')->name('admin.transactions.show');
                });

                Route::resource('/categories', CategorieController::class);
                Route::resource('/skill', SkillController::class);
                Route::resource('/experience', ExperienceController::class);
                Route::resource('/duration', DurationController::class);
            }
        );


        

        // service_provider
        Route::group(
            [
                'middleware' => ['auth', 'checkusertype:service_provider'],
                'prefix' => '/service_provider'
            ],
            function () {
                Route::group([
                    'controller' => Service_providerDashboardController::class,
                ], function () {
                    Route::get('/dashboard', 'index')->name('service_provider.dashboard');
                });

                Route::resource('/Profiles', ProfileServiceProviderController::class);

                Route::group([
                    'controller' => MyWorkController::class,
                    'prefix' => '/MyWork'
                ], function () {
                    Route::get('/index', 'index')->name('MyWork.index');
                    Route::post('/store', 'store')->name('MyWork.store');
                    Route::post('/update/{id}', 'update')->name('MyWork.update');
                    Route::post('/destroy/{id}', 'destroy')->name('MyWork.destroy');
                });

                
                // Route::resource('/service', ServiceController::class);
                Route::get('/transactions', [TransactionController::class, 'indexForServiceProvider'])->name('service_provider.transactions');
                Route::group([
                    'controller' => Service_providerProjectController::class
                ], function () {
                    Route::get('/projects', 'index')->name('projects.index');
                    Route::get('/projects/show/{id}', 'show')->name('projects.show');
                    Route::post('/projects/offer_add/{id}', 'store_offer')->name('projects.offer_add');
                    Route::post('/categories/skills/{id}', 'skill');
                    Route::post('/search', 'search')->name('project.search');
                });
            }
        );
        Route::group([
            'controller' => ServiceProviderController::class,
            'prefix' => '/withdraw'
        ], function () {
            Route::get('/', 'withdraw')->name('service_provider.withdraw');
            Route::post('/request', 'requestWithdrawal')->name('service_provider.withdraw.request');
        });

        // client
        Route::group(
            [
                'middleware' => ['auth', 'checkusertype:client'],
                'prefix' => '/client',
                'controller' => ClientDashboardController::class,
            ],
            function () {
                Route::get('/dashboard', 'index')->name('Client.dashboard');
                Route::resource('/Prosodic', ProjectController::class);
                Route::post('/rating', [ProjectController::class,'rating'])->name('Client.rating');
                Route::post('/Prosodic/offer/enable/{id}', [OfferController::class, 'enable'])->name('offer.enable');
                Route::get('/Profile/Service_provider/{id}', [ProfileController::class, 'show'])->name('Profile.show');
                Route::post('/categories/skills/{id}', [ProjectController::class, 'skill']);
                Route::get('/transactions', [TransactionController::class, 'indexForClient'])->name('client.transactions');
            }
        );


        Route::group([
            'prefix' => '/chat',
            'controller' => ChatController::class,
            'middleware' => ['auth'],
        ], function () {
            Route::get('/', 'index')->name('chat.index');
            Route::get('/get/{chat}', 'show')->name('chat.show');
            Route::post('{chat}/send-message', 'sendMessage')->name('chat.send');
            Route::get('{chat}/{lastMessage}', 'getNewMessages');
        });

        Route::get('/meetings/{id}', [MeetingController::class, 'createMeeting'])->name('meetings.create');



        Route::group([
            'prefix' => '/disputes',
            'controller' => DisputeController::class,
            'middleware' => ['auth'],
        ], function () {
            Route::get('/index', 'index')->name('user.disputes.index');
            Route::get('/add', 'add')->name('user.disputes.add');
            Route::get('/{dispute}', 'show')->name('user.disputes.show');
            Route::post('/store', 'store')->name('user.disputes.store');
            Route::post('/{dispute}/messages', 'addMessage')->name('user.disputes.addMessage');
        });


    }
);
