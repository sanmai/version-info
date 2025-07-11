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

namespace VersionInfo;

use VersionInfo\Contracts\VersionReader;

final class ComposerBranchAliasVersionReader implements VersionReader
{
    /** @var string */
    private $composerJsonPath;

    /** @var string */
    private $mainBranch;

    /**
     * @param string $composerJsonPath Path to composer.json at the root of the project. Must have a master branch alias. Incurs some IO penalty.
     */
    public function __construct(string $composerJsonPath, string $mainBranch = 'main')
    {
        $this->composerJsonPath = $composerJsonPath;
        $this->mainBranch = $mainBranch;
    }

    public function getVersionString(): ?string
    {
        if (!is_file($this->composerJsonPath)) {
            return null;
        }

        /** @phan-suppress-next-line PhanTypeArraySuspiciousNullable */
        return @json_decode((string) file_get_contents($this->composerJsonPath), true)['extra']['branch-alias']['dev-'.$this->mainBranch];
    }
}
