<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Http\Requests\UserAddressRequest;

class UserAddressesController extends Controller
{
    //
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('user_addresses.index', [
            'addresses' => $request->user()->addresses,
        ]);
    }

    public function create()
    {
        return view('user_addresses.create_and_edit',['address'=>new UserAddress()]);
    }

    /**
     * @param UserAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserAddressRequest $request)
    {
        $request->user()->address()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone'
            ])

        );

        return redirect()->route('user_addresses.index');
    }

    /**
     * @param UserAddress $user_address
     * @param UserAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse、
     */
    public function update(UserAddress $user_address, UserAddressRequest $request)
    {
        $this->authorize('own', $user_address);
        $user_address->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contract_name',
            'contact_phone'
        ]));
        return redirect()->route('user_addresses.index');
    }

    /**
     * @param UserAddress $user_address
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(UserAddress $user_address)
    {
        $this->authorize('own', $user_address);
        return view('user_addresses.create_and_edit',[
            'address'=> $user_address
        ]);
    }

    /**
     * @param UserAddress $user_address
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Useraddress $user_address)
    {
        $this->authorize('own', $user_address);
        $update = $user_address;//此处需要修改为软删除

        //return redirect()->route('user_addresses.index');
        return [];
    }


}
