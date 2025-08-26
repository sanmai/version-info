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

final class PlaceholderVersionReader implements VersionReader
{
    /** @var string */
    private $versionInfoString;

    /**
     * @param string $versionInfoString Contents of a constant with a placeholder like '$Format:%h%d by %an +%ae$' or '$Format:%h%d$'
     */
    public function __construct(string $versionInfoString)
    {
        $this->versionInfoString = $versionInfoString;
    }

    public function getVersionString(): ?string
    {
        if ($this->versionInfoString[0] === '$') {
            return null;
        }

        /** @var string[] $parts */
        if (preg_match('/^([0-9a-f]+).*?tag: (v?[\d\.]+)\)(.*)/', $this->versionInfoString, $parts)) {
            return "{$parts[2]}-{$parts[1]}{$parts[3]}";
        }

        return null;
    }
}
