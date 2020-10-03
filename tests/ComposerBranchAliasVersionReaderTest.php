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
use VersionInfo\ComposerBranchAliasVersionReader;

/**
 * @covers \VersionInfo\ComposerBranchAliasVersionReader
 */
class ComposerBranchAliasVersionReaderTest extends TestCase
{
    public function test_it_reads_version_using_relative_path()
    {
        $reader = new ComposerBranchAliasVersionReader(__DIR__.'/../composer.json', 'master');
        $version = $reader->getVersionString();

        $this->assertSame('0.1.x-dev', $version);
    }

    public function test_it_reads_version_using_absolute()
    {
        $reader = new ComposerBranchAliasVersionReader(\realpath(__DIR__.'/../composer.json'), 'master');
        $version = $reader->getVersionString();

        $this->assertSame('0.1.x-dev', $version);
    }

    public function test_it_does_not_read_version_when_there_is_no_file()
    {
        $reader = new ComposerBranchAliasVersionReader(__DIR__);
        $version = $reader->getVersionString();

        $this->assertNull($version);
    }

    public function test_it_does_cause_errors_when_there_is_no_branch_alias()
    {
        $fh = \tmpfile();
        \fwrite($fh, '{}');

        $tempFilePath = \stream_get_meta_data($fh)['uri'];

        $this->assertNotNull(\json_decode(\file_get_contents($tempFilePath)));

        $reader = new ComposerBranchAliasVersionReader($tempFilePath);
        $version = $reader->getVersionString();

        $this->assertNull($version);
    }
}
