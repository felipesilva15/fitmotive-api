<?php

namespace App\Http\Controllers;

use App\Services\ViaCep\SearchCepService;
use Illuminate\Routing\Controller as BaseController;

class SearchCepController extends BaseController
{
    /**
     * @OA\Get(
     *      path="/api/cep/{cep}",
     *      tags={"Search CEP"},
     *      summary="Get address by CEP",
     *      @OA\Parameter(
     *         name="cep",
     *         in="path",
     *         required=true,
     *         description="CEP",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Address data",
     *          @OA\JsonContent(ref="#/components/schemas/AddressDTO")
     *     ),
     *     @OA\Response(
     *          response="400", 
     *          description="Invalid CEP",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *     ),
     *     @OA\Response(
     *          response="500", 
     *          description="External tool error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *     )
     * )
     */
    public function getAddressByCep(string $cep){
        $address = SearchCepService::getAddressByCep($cep);

        return response()->json($address->toArray(), 200);
    }
}
