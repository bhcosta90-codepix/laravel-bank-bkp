<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Illuminate\Testing\TestResponse;
use Mockery\MockInterface;

uses(
    Tests\TestCase::class,
     Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

function trace(TestResponse $response){
    if($response->status() == 500) {
        $trace = $response->json('trace');
        krsort($trace);
        dump($trace, $response->json('message'));
    }
}

function mockAction(
    MockInterface $response,
    array $actions,
): void {
    foreach ($actions as $key => $action) {
        $response = $response->shouldReceive($key);

        if (!is_array($action)) {
            $action = [
                'action' => $action,
            ];
        }
        if (!empty($action['with'])) {
            $response->with($action['with']);
        }

        $response->andReturn($action['action']())
            ->times($action['times'] ?? 1);
    }
}
