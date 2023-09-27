<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class StatService
{
    private function getApiUserRequestKey(User $user): string
    {
        return "api:users:$user->id";
    }
    private function getApiTotalRequestsKey(): string
    {
        return "api-total-request";
    }

    public function hit(User $user): void
    {
        Cache::increment($this->getApiUserRequestKey($user));
    }

    public function calculateTotalRequest(): void
    {
        $users = User::query()
            ->get();

        $count = 0;
        foreach($users as $user) {
            $count += $this->requestsByUser($user);
        }

        Cache::set($this->getApiTotalRequestsKey(), $count);
    }

    public function totalRequest(): int
    {
        return (int) Cache::get($this->getApiTotalRequestsKey());
    }

    public function requestsByUser(User $user): int
    {
        return (int)Cache::get($this->getApiUserRequestKey($user), 0);
    }
}
