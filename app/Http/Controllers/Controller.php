<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Exceptions\BusinessLogicException;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function testHandler(Request $request)
    {
        // try {

        // $item = Item::findOrFail($id);
        // $item->update($validatedData);

        // return response()->json(['message' => 'Item updated successfully!']);
        // } catch (ValidationException $e) {
        // // Laravel automatically handles validation exceptions
        // throw $e; // just threw exception without message and code, will be added in handler
        // }

        if (true) {
            throw new BusinessLogicException("Custom error message", 400); // must send message and code here
        }
    }
}
