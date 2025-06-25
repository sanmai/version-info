<?php

/**
 * This code is licensed under the MIT License.
 *
 * Copyright (c) 2020 Alexey Kopytko <alexey@kopytko.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

declare(strict_types=1);

namespace Tests\ShipAndCoSDK;

use PHPUnit\Framework\TestCase;
use VersionInfo\Example;
use VersionInfo\PlaceholderVersionReader;

/**
 * @covers \VersionInfo\Example
 */
class ExampleTest extends TestCase
{
    public function test_it_has_correct_version_string_constant()
    {
        if ((new PlaceholderVersionReader(Example::VERSION_INFO))->getVersionString() !== null) {
            $this->markTestSkipped('Skipping development test');
        }

        $this->assertSame(1, preg_match('/^\$Format:%h%d.*\$$/', Example::VERSION_INFO));
    }

    public function test_it_returns_version()
    {
        $example = new Example();

        $version = $example->getVersionString();

        $this->assertIsString($version);
        $this->assertNotEmpty($version);
    }
}
