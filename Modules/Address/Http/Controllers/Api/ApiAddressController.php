<?php

namespace Modules\Address\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Address\Http\Requests\StoreAddressRequest;
use Modules\Address\Repositories\AddressRepoEloquentInterface;
use Modules\Address\Services\AddressService;
use Modules\Share\Http\Controllers\Controller;

class ApiAddressController extends Controller
{
    public AddressRepoEloquentInterface $addressRepo;
    public AddressService $addressService;

    /**
     * @param AddressRepoEloquentInterface $addressRepoEloquent
     * @param AddressService $addressService
     */
    public function __construct(AddressRepoEloquentInterface $addressRepoEloquent,
                                AddressService               $addressService,)
    {
        $this->addressRepo = $addressRepoEloquent;
        $this->addressService = $addressService;
    }

    /**
     * @param StoreAddressRequest $request
     * @return JsonResponse
     */
    public function addAddress(StoreAddressRequest $request): JsonResponse
    {
        $this->addressService->store($request);
        return response()->json(['message' => 'آدرس با موفقیت ثبت شد',
            'status' => 'success',
            'data' => null]);
    }
}
