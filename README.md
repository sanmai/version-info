# Version info parser

[![Latest Stable Version](https://poser.pugx.org/sanmai/version-info/v/stable)](https://packagist.org/packages/sanmai/version-info)
[![Coverage Status](https://coveralls.io/repos/github/sanmai/version-info/badge.svg?branch=master)](https://coveralls.io/github/sanmai/version-info?branch=master)

This small library solves a problem where a package wants to know or report own version.

This is not a new problem, e.g. there's [ocramius/package-versions](https://github.com/Ocramius/PackageVersions),
but it depends heavily on Composer, and not without an associated IO penalty.

On the contrary, this package solves the same problem but without any extra IO whatsoever. What you need 
is to instruct Git to [expand placeholders](https://git-scm.com/docs/gitattributes#_export_subst) (detailed 
instructions below) when adding a file with a constant to an archive of a tagged release. Then you feed 
this constant to the library, and there is your version.

Sure, you can't be certain people always install a package from archives. In this case you can use 
either abovementioned [ocramius/package-versions](https://github.com/Ocramius/PackageVersions), or
use [two auxiliary classes](#fallback-readers) this library provides to fetch version strings right from Git or from a [branch 
alias](https://getcomposer.org/doc/articles/aliases.md#branch-alias) from `composer.json`.

## Installation

```bash
composer require sanmai/version-info
```

This library needs PHP 7.4 or greater. It was tested to work under PHP 7.x and 8.0.

## Usage

Create a PHP class (or use existing class) with the following constant: 

```php
const VERSION_INFO = '$Format:%h%d by %an +%ae$'; // or '$Format:%h%d$'
```

Amend `.gitattributes` with a path to the file with the class with `export-subst` attribute:

```
/src/MyVersion.php     export-subst
```

Where you want to know your version, call a version reader:

```php
$reader = \VersionInfo\PlaceholderVersionReader(MyVersion::VERSION_INFO);
$version = $versionReader->getVersionString();

if ($version !== null) {
    return $version;
}

// Fallback on other methods, or return a dummy version.
// See src/Example.php for a complete example.
```

That's all!

## Testing

To verify that your version constant is being correctly replaced you can use `git archive` command, pointing it at a tag, or a branch:

```bash
git archive --format=tar v1.1 | grep --text VERSION_INFO
```

The constant should contain something like:

```
c3ff8f6 (tag: v1.1) by John Doe +john.doe@example.com
```

## Fallback readers 

Apart from `PlaceholderVersionReader` there are `GitVersionReader` and `ComposerBranchAliasVersionReader`. [See this example for details.](src/Example.php)

## Memoization

Any of these classes do not do their own memoization. If you need memoization and lazy loading, try [Later, a deferred object manager](https://github.com/sanmai/later).

```php
use function Later\later;

$deferredVersion = later(function () {
    $reader = \VersionInfo\PlaceholderVersionReader(MyVersion::VERSION_INFO);
    
    yield $version = $versionReader->getVersionString();
});

// And at some later point...
$deferredVersion->get(); // returns memoized version string, computing it on the spot, as needed
```

## License

This project is licensed [under the terms of the MIT license](LICENSE).




