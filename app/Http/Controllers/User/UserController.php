<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\GetRequest;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Services\User\UserService;

class UserController extends Controller
{
    protected UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function index(GetRequest $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'No tens permisos.'], 403);
        }

        return $this->service->get(
            $request->input('include'),
            $request->input('filter'),
            $request->input('sort'),
            $request->input('perPage'),
        );
    }

    public function save(User $user, UserRequest $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'No tens permisos.'], 403);
        }

        return $this->service->save($user, $request);
    }

    public function delete(User $user)
    {
        if (!request()->user()->isAdmin()) {
            return response()->json(['message' => 'No tens permisos.'], 403);
        }

        if ($user->is_admin) {
            return response()->json(['message' => 'No pots eliminar un administrador.'], 422);
        }

        $this->service->delete($user);

        return response()->json(['message' => 'Usuari eliminat correctament.']);
    }
}
