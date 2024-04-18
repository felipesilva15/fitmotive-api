<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface CrudControllerInterface
{
    public function index();

    public function show($id);

    public function store(Request $request);

    public function update(Request $request, $id);

    public function destroy($id);

    public function toogleActivation($id);
}