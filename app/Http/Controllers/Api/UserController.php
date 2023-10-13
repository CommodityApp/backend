<?php

namespace App\Http\Controllers\Api;

use App\Filters\SearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CreateUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(
                'name',
                'email',
                'id',
                AllowedFilter::custom('q', new SearchFilter(['name', 'email']))
            )
            ->allowedSorts('id', 'name', 'email')
            ->allowedIncludes('firstActivity.causer', 'roles')
            ->paginate(request()->input('per_page', 15));

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->safe()->only(['name', 'email', 'password']);
        $data['password'] = ! empty($data['password']) ? bcrypt($data['password']) : $data['password'];

        $user = User::create($data);
        $user->syncRoles($request->safe()->roles);

        return new UserResource($user->load('roles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user->load('activities.causer', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->safe()->only(['name', 'email', 'password']);

        $data['password'] = ! empty($data['password']) ? bcrypt($data['password']) : $user->password;

        $user->update($data);

        return new UserResource($user->load('activities.causer', 'roles'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $user->id;
    }
}
