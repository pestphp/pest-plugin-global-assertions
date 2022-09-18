<?php

declare(strict_types=1);

it('adds global assertions', function (): void {
    expect(function_exists('assertTrue'))->toBeTrue(); // @phpstan-ignore-line
    assertTrue(true);
});

it('defines constant for global assertions', function (): void {
    assertTrue(defined('__PEST_GLOBAL_ASSERT_WRAPPERS__'));
    assertEquals(true, __PEST_GLOBAL_ASSERT_WRAPPERS__);
});
