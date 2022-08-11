<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

# Used to opened and reopened PR
# Send params 
# branch=jhg
Route::post('/sub-domains/{slug}', function (Request $request, $slug) {
    # Call script to create new virtual environment
    # - create route 53 subdomain
    # - create virtual host file
    # - clone repo at specific branch
    # - restart nginx

    # Notify in Github issue/PR comment

    return $slug;

});

# Used to closed PR
# Send params 
# merged=false
# branch=jhg
Route::delete('/sub-domains/{slug}', function (Request $request, $slug) {
    # Call script to destroy virtual environment
    # - delete route 53 subdomain
    # - delete virtual host file
    # - delete repo at specific slug
    # - restart nginx

    # Notify in Github issue/PR comment 

    return $slug;
});

# Used to merged PR
# Send params 
# merged=true
# target_branch=abc
# branch=jhg
Route::delete('/sub-domains/{slug}', function (Request $request, $slug) {
    # Call script to destroy virtual environment
    # - delete route 53 subdomain
    # - delete virtual host file
    # - delete repo at specific slug
    # - restart nginx

    # Deploy target branch with new code
    # - pull latest changes
    # - restart nginx

    # Notify in Github issue/PR comment that PR successfull merged

    return $slug;
})

# Used to sync PR
# Send params 
# branch=jhg
Route::put('/sub-domains/{slug}', function (Request $request, $slug) {
    # Deploy branch with new code
    # - pull latest changes
    # - restart nginx

    return $slug;
});
