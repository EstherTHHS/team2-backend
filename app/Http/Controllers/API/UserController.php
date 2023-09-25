<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SocialLoginRequest;

class UserController extends Controller
{

    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
        // $this->middleware('permission:userList', ['only' => 'index']);
        // $this->middleware('permission:userShow', ['only' => 'show']);
        // $this->middleware('permission:userUpdate', ['only' => 'update']);
        // $this->middleware('permission:userDestroy', ['only' => 'destroy']);
        // $this->middleware('permission:userStatus', ['only' => 'userStatus']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //getUsers

        try {

            $startTime = microtime(true);

            $data = $this->service->getUsers();

            return response()->success($request, $data, 'User Lists Successfully.', 201, $startTime, 1);
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error('User Lists Error' . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {

        // try {

        //     $startTime = microtime(true);

        //     $validatedData = $request->validated();

        //     $data = $this->service->storeUser($validatedData);

        //     return response()->success($request, $data, 'User Register Successfully.', 201, $startTime, 1);
        // } catch (Exception $e) {
        //     Log::channel('sora_error_log')->error('Register Error' . $e->getMessage());
        //     return response()->error($request, null, $e->getMessage(), 500, $startTime);
        // }
    }



    public function socialLogin(SocialLoginRequest $request)
    {
        $startTime = microtime(true);

        try {
            $user = User::where('provider', $request->provider)
                ->where('key', $request->key)
                ->where('name', $request->name)
                ->first();

            if ($user == null) {

                $validatedData = $request->validated();
                $user = $this->service->socialLogin($validatedData);
            }


            if ($user) {

                Auth::login($user);
                $success['id'] = $user->id;
                $success['name'] = $user->name;
                $success['email'] = $user->email;
                $success['token'] = $user->createToken('User API')->plainTextToken;
                $userRoles = $user->getRoleNames();
                $success['role'] = $userRoles->first();
                $success['permission'] = $user->getPermissionsViaRoles()->pluck('name');

                return response()->success($request, $success, 'User Login Successful', 200, $startTime, 1);
            } else {

                return response()->error($request, null, 'User Not Found', 404, $startTime);
            }
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error('Social Login Error: ' . $e->getMessage());
            return response()->error($request, null, 'Internal Server Error', 500, $startTime);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $id)
    {


        try {

            $startTime = microtime(true);


            $data = $this->service->showUser($request,$id);

            return response()->success($request, $data, 'User Show Successfully.', 201, $startTime, 1);
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error('Register Error' . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegisterRequest $request, string $id)
    {
      try {

            $startTime = microtime(true);

            $validatedData = $request->validated();

            $data = $this->service->updateUser($validatedData,$id);

            return response()->success($request, $data, 'User Update Successfully.', 201, $startTime, 1);
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error('Register Error' . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        try {

            $startTime = microtime(true);



            $data = $this->service->destroy($request,$id);

            return response()->success($request, $data, 'User Delete Successfully.', 200, $startTime, 1);
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error('Register Error' . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }

    public function register(RegisterRequest $request)
    {

        try {

            $startTime = microtime(true);

            $validatedData = $request->validated();

            $data = $this->service->storeUser($validatedData);

            return response()->success($request, $data, 'User Register Successfully.', 201, $startTime, 1);
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error('Register Error' . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }


    public function userStatus(Request $request,$id)
    {

        try {

            $startTime = microtime(true);

            $data = $this->service->userStatus($request,$id);

            return response()->success($request, $data, 'User Status change  Successfully.', 200, $startTime, 1);
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error('Error User Status change' . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }
}
