<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Github
{
    private $token;

    protected $issueNumber;

    public function __construct($token = null) {
       
        $this->token = is_null($token) ? config('github.access_token') : $token;
    }

    public function setIssueNumber($number) {
        Log::info([
            "issue_number" => $number
        ]);
        $this->issueNumber = $number; 
        return $this;                             
    }

    public function comment($comment)
    {
        Log::info([
            "issue_number from comment" => $this->issueNumber,
            "token" => $this->token
        ]);
        $response = Http::withHeaders([
            "Authorization" => "token {$this->token}",
            "Accept" => "application/vnd.github+json"
        ])->post("https://api.github.com/repos/fathur/gitflow-workflow/issues/{$this->issueNumber}/comments", [
            "body" => $comment
        ]);
    }
}