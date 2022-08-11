<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\Github;
use App\Models\SubDomain;

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
# pr_number=3
Route::post('/sub-domains/{slug}', function (Request $request, $slug) {
    $branch = $request->get('branch');
    $number = $request->get("pr_number");

    $url = "http://{$slug}.fathur.io/";

    # Call script to create new virtual environment
    // (new Deployer)->createDNSDomain("{$slug}.fathur.io")
    //     ->cloneRepoInBranch($branch)
    //     ->createNginxVirtualHost()
    //     ->restartNginx();

    # Store in the database to check the creation status
    SubDomain::create([
        'sub_domain' => $slug
    ]);

    # Notify in Github issue/PR comment
    $message = "Awesome! 🎊 🎉 You can test your PR using the environment in the URL below.\n\n" .
        "✅ {$url} \n\n" .
        "[🤖]";
    (new Github)->setIssueNumber($number)
        ->comment($message);

    return $slug;

});

# Used to merged PR
# Send params 
# merged=true
# target_branch=abc
# branch=jhg
Route::delete('/sub-domains/{slug}', function (Request $request, $slug) {
    $branch = $request->get('branch');
    $number = $request->get("pr_number");
    $merged = $request->boolean("merged");

    Log::info([
        "merged" => $merged
    ]);

    # Call script to destroy virtual environment
    // (new Deployer)->deleteDNSDomain("{$slug}.fathur.io")
    //     ->deleteRepoInBranch($branch)
    //     ->deleteNginxVirtualHost()
    //     ->restartNginx();

    if ($merged) {

        # Deploy target branch with new code
        # - pull latest changes
        # - restart nginx

        # Notify in Github issue/PR comment that PR successfull merged
        $message = "Congrats! your PR successfully merged 🎊 🎊. The previous generated URL and its environment can no longer be used.";
        (new Github())->setIssueNumber($number)
            ->comment($message);
    }

    # Delete record from DB
    SubDomain::where('sub_domain', $slug)->delete();

    return $slug;
});

# Used to sync PR
# Send params 
# branch=jhg
Route::put('/sub-domains/{slug}', function (Request $request, $slug) {
    # Deploy branch with new code
    # - pull latest changes
    # - restart nginx

    if (!SubDomain::where('sub_domain', $slug)->exists()) {
        SubDomain::create([
            'sub_domain' => $slug
        ]);

        # Notify in Github issue/PR comment
        $message = "Awesome! 🎊 🎉 You can test your PR using the environment in the URL below.\n\n" .
            "✅ {$url} \n\n" .
            "[🤖]";
        (new Github)->setIssueNumber($number)
            ->comment($message);
    }

    return $slug;
});
