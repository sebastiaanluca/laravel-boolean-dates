# Automatically convert Eloquent model boolean attributes to dates (and back)

[![Latest stable release][version-badge]][link-packagist]
[![Software license][license-badge]](LICENSE.md)
[![Build status][travis-badge]][link-travis]
[![Total downloads][downloads-badge]][link-packagist]

[![Read my blog][blog-link-badge]][link-blog]
[![View my other packages and projects][packages-link-badge]][link-packages]
[![Follow @sebastiaanluca on Twitter][twitter-profile-badge]][link-twitter]
[![Share this package on Twitter][twitter-share-badge]][link-twitter-share]

**A package to automatically convert boolean fields to dates (and back to booleans) so you always know when something was accepted or changed.**

Say you've got a registration page for users where they need to accept your terms and perhaps can opt-in to certain features using checkboxes. With the new(-ish) GDPR privacy laws, you're somewhat required to not just keep track of the fact *if* they accepted those (or not), but also *when* they did.

### Example

User registration controller:

```php
$input = request()->input();

$user = User::create([
    'has_accepted_terms_and_conditions' => $input['terms'],
    'allows_data_processing' => $input['data_processing'],
    'has_agreed_to_something' => $input['something'],
]);
```

Anywhere else in your code:

```php
$user->has_accepted_terms_and_conditions;

/*
 * true or false (boolean)
 */
 
$user->accepted_terms_and_conditions_at;

/*
 * 2018-05-10 16:24:22 (Carbon instance)
 */
```

## Table of contents

- [Requirements](#requirements)
- [How to install](#how-to-install)
- [How to use](#how-to-use)
    - [Saving dates](#saving-dates)
    - [Clearing saved values](#clearing-saved-values)
    - [Retrieving values](#retrieving-values)
        - [Retrieving fields as booleans](#retrieving-fields-as-booleans)
        - [Retrieving fields as datetimes](#retrieving-fields-as-datetimes)
    - [Array conversion](#array-conversion)
- [License](#license)
- [Change log](#change-log)
- [Testing](#testing)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [About](#about)

## Requirements

- PHP 7.2 or higher
- Laravel 5.8 or higher

## How to install

**Add the package** to your project using composer:

```bash
composer require sebastiaanluca/laravel-boolean-dates
```

**Require the `HasBooleanDates` trait** in your Eloquent model, then add the `$booleanDates` field:

```php
<?php

use Illuminate\Database\Eloquent\Model;
use SebastiaanLuca\BooleanDates\HasBooleanDates;

class User extends Model
{
    use HasBooleanDates;
    
    /**
     * @var array
     */
    protected $booleanDates = [
        'has_accepted_terms_and_conditions' => 'accepted_terms_at',
        'allows_data_processing' => 'accepted_processing_at',
        'has_agreed_to_something' => 'agreed_to_something_at',
    ];
}
```

To wrap up, create a **migration** to create a new or alter your existing table and add the timestamp fields:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgreementFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('accepted_terms_at')->nullable();
            $table->timestamp('accepted_processing_at')->nullable();
            $table->timestamp('agreed_to_something_at')->nullable();
        });
    }
}
```

Note: the related boolean fields are dynamic and do not need database fields.

## How to use

### Saving dates

If a boolean date field's value is true, it'll be automatically converted to the current datetime:

```php
$user = new User;

// Setting values explicitly
$user->has_accepted_terms_and_conditions = true;
$user->allows_data_processing = 'yes';

// Or using attribute filling
$user->fill([
   'has_agreed_to_something' => 1, 
]);

$user->save();
```

All fields should now contain a datetime similar to `2018-05-10 16:24:22`.

### Clearing saved values

Of course you can also remove the saved date and time, for instance if a user retracts their approval:

```php
$user = User::findOrFail(42);

$user->has_accepted_terms_and_conditions = false;
// $user->has_accepted_terms_and_conditions = null;

$user->allows_data_processing = 0;
// $user->allows_data_processing = '0';

$user->has_agreed_to_something = '';

$user->save();
```

False or false-y values are converted to `NULL`.

### Retrieving values

#### Retrieving fields as booleans

Use a boolean field's defined _key_ to access its boolean value:

```php
$user = User::findOrFail(42);

$user->has_accepted_terms_and_conditions;

/*
 * true or false (boolean)
 */
```

#### Retrieving fields as datetimes

Use a boolean field's defined _value_ to explicitly access its (Carbon) datetime value:

```php
$user = User::findOrFail(42);

$user->accepted_terms_at;

/*
 * 2018-05-10 16:24:22 (Carbon instance)
 */

$user->accepted_processing_at;

/*
 * NULL
 */
```

### Array conversion

When converting a model to an array, all boolean fields ánd their datetimes will be included:

```php
$user = User::findOrFail(42);

$user->toArray();

/*
 * Which will return something like:
 * 
 * [
 *     'accepted_terms_at' => \Carbon\Carbon('2018-05-10 16:24:22'),
 *     'accepted_processing_at' => NULL,
 *     'agreed_to_something_at' => \Carbon\Carbon('2018-05-10 16:24:22'),
 *     'accepted_terms_and_conditions' => true,
 *     'allows_data_processing' => false,
 *     'agreed_to_something' => true,
 * ];
 */
```

## License

This package operates under the MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer install
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email [hello@sebastiaanluca.com][link-author-email] instead of using the issue tracker.

## Credits

- [Sebastiaan Luca][link-github-profile]
- [All Contributors][link-contributors]

## About

My name is Sebastiaan and I'm a freelance back-end developer specializing in building custom Laravel applications. Check out my [portfolio][link-portfolio] for more information, [my blog][link-blog] for the latest tips and tricks, and my other [packages][link-packages] to kick-start your next project.

Have a project that could use some guidance? Send me an e-mail at [hello@sebastiaanluca.com][link-author-email]!

[version-badge]: https://poser.pugx.org/sebastiaanluca/laravel-boolean-dates/version
[license-badge]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[travis-badge]: https://img.shields.io/travis/sebastiaanluca/laravel-boolean-dates/master.svg
[downloads-badge]: https://img.shields.io/packagist/dt/sebastiaanluca/laravel-boolean-dates.svg

[blog-link-badge]: https://img.shields.io/badge/link-blog-lightgrey.svg
[packages-link-badge]: https://img.shields.io/badge/link-other_packages-lightgrey.svg
[twitter-profile-badge]: https://img.shields.io/twitter/follow/sebastiaanluca.svg?style=social
[twitter-share-badge]: https://img.shields.io/twitter/url/http/shields.io.svg?style=social

[link-packagist]: https://packagist.org/packages/sebastiaanluca/laravel-boolean-dates
[link-travis]: https://travis-ci.org/sebastiaanluca/laravel-boolean-dates
[link-contributors]: ../../contributors

[link-portfolio]: https://www.sebastiaanluca.com
[link-blog]: https://blog.sebastiaanluca.com
[link-packages]: https://packagist.org/packages/sebastiaanluca
[link-twitter]: https://twitter.com/sebastiaanluca
[link-twitter-share]: https://twitter.com/intent/tweet?text=Easily%20convert%20Eloquent%20model%20booleans%20to%20dates%20and%20back%20with%20Laravel%20Boolean%20Dates.%20Via%20@sebastiaanluca%20https://github.com/sebastiaanluca/laravel-boolean-dates
[link-github-profile]: https://github.com/sebastiaanluca
[link-author-email]: mailto:hello@sebastiaanluca.com
