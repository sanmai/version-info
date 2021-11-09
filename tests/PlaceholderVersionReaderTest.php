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
use VersionInfo\PlaceholderVersionReader;

/**
 * @covers \VersionInfo\PlaceholderVersionReader
 */
class PlaceholderVersionReaderTest extends TestCase
{
    /**
     * @dataProvider versionStringProvider
     */
    public function test_it_reads_version_from_string(string $versionString, ?string $expected)
    {
        $reader = new PlaceholderVersionReader($versionString);

        $this->assertSame($expected, $reader->getVersionString());
    }

    public function versionStringProvider()
    {
        yield [
            '123fffa (HEAD -> master) by John Doe +john.doe@example.com',
            null,
        ];

        yield [
            '123fffa (HEAD -> master)',
            null,
        ];

        yield [
            '2527861 (HEAD -> main, tag: 1.1.8) by John Doe +john.doe@example.com',
            '1.1.8-2527861 by John Doe +john.doe@example.com',
        ];

        yield [
            'c3ff8f6 (tag: v1.2) by John Doe +john.doe@example.com',
            'v1.2-c3ff8f6 by John Doe +john.doe@example.com',
        ];

        yield [
            'c3ff8f6 (tag: v1.2)',
            'v1.2-c3ff8f6',
        ];

        yield [
            '$Format:%h%d by %an +%ae$',
            null,
        ];

        yield [
            '$Format:%h%d$',
            null,
        ];

        yield [
            '$',
            null,
        ];
    }
}
