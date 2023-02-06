# Convert Eloquent boolean attributes to dates (and back)

[![Latest stable release][version-badge]][link-packagist]
[![Software license][license-badge]](LICENSE.md)
[![Build status][travis-badge]][link-travis]
[![Total downloads][downloads-badge]][link-packagist]
[![Total stars][stars-badge]][link-github]

[![Read my blog][blog-link-badge]][link-blog]
[![View my other packages and projects][packages-link-badge]][link-packages]
[![Follow @sebastiaanluca on Twitter][twitter-profile-badge]][link-twitter]
[![Share this package on Twitter][twitter-share-badge]][link-twitter-share]

**Automatically convert Eloquent model boolean fields to dates (and back to booleans)** so you always know _when_ something was accepted or changed.

Say you've got a registration page for users where they need to accept your terms and perhaps can opt-in to certain features using checkboxes. With the new(-ish) GDPR privacy laws, you're somewhat required to not just keep track of the fact *if* they accepted those (or not), but also *when* they did.

### Example

User registration controller:

```php
$input = request()->input();

$user = User::create([
    'has_accepted_terms' => $input['terms'],
    'is_subscribed_to_newsletter' => $input['newsletter'],
]);
```

Anywhere else in your code:

```php
// true or false (boolean)
$user->has_accepted_terms;

// 2018-05-10 16:24:22 (Carbon instance)
$user->accepted_terms_at;
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

- PHP 8.1 or 8.2
- Laravel 10

## How to install

**Add the package** to your project using composer:

```bash
composer require sebastiaanluca/laravel-boolean-dates
```

**Set up your Eloquent model** by:

1. Adding your datetime columns to `$casts`
2. Adding the boolean attributes to `$appends`
3. Creating attribute accessors and mutators for each field

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use SebastiaanLuca\BooleanDates\BooleanDateAttribute;

class User extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'accepted_terms_at' => 'immutable_datetime',
        'subscribed_to_newsletter_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'has_accepted_terms',
        'is_subscribed_to_newsletter',
    ];

    protected function hasAcceptedTerms(): Attribute
    {
        return BooleanDateAttribute::for('accepted_terms_at');
    }

    protected function isSubscribedToNewsletter(): Attribute
    {
        return BooleanDateAttribute::for('subscribed_to_newsletter_at');
    }
}
```

Optionally, if your database table hasn't got the datetime columns yet, create a **migration** to create a new table or alter your existing table to add the timestamp fields:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table): void {
            $table->timestamp('accepted_terms_at')->nullable();
            $table->timestamp('subscribed_to_newsletter_at')->nullable();
        });
    }
};

```

## How to use

### Saving dates

If a boolean date field's value is true-ish, it'll be automatically converted to the current datetime. You can use anything like booleans, strings, positive integers, and so on.

```php
$user = new User;

// Setting values explicitly
$user->has_accepted_terms = true;
$user->has_accepted_terms = 'yes';
$user->has_accepted_terms = '1';
$user->has_accepted_terms = 1;

// Or using attribute filling
$user->fill(['is_subscribed_to_newsletter' => 'yes']);

$user->save();
```

All fields should now contain a datetime similar to `2018-05-10 16:24:22`.

Note that the date stored in the database column **is immutable, i.e. it's only set once**. Any following updates will not change the stored date(time), unless you update the date column manually or if you set it to `false` and back to `true` (disabling, then enabling it).

For example:

```php
$user = new User;

$user->has_accepted_terms = true;
$user->save();

// `accepted_terms_at` column will contain `2022-03-13 13:20:00`

$user->has_accepted_terms = true;
$user->save();

// `accepted_terms_at` column will still contain the original `2022-03-13 13:20:00` date
```

### Clearing saved values

Of course you can also remove the saved date and time, for instance if a user retracts their approval:

```php
$user = User::findOrFail(42);

$user->has_accepted_terms = false;
$user->has_accepted_terms = null;
$user->has_accepted_terms = '0';
$user->has_accepted_terms = 0;
$user->has_accepted_terms = '';
// $user->has_accepted_terms = null;

$user->save();
```

False or false-y values are converted to `NULL`.

### Retrieving values

#### Retrieving fields as booleans

Use a boolean field's defined _key_ to access its boolean value:

```php
$user = User::findOrFail(42);

// true or false (boolean)
$user->has_accepted_terms;
```

#### Retrieving fields as datetimes

Use a boolean field's defined _value_ to explicitly access its (Carbon) datetime value:

```php
$user = User::findOrFail(42);

// 2018-05-10 16:24:22 (Carbon or CarbonImmutable instance)
$user->accepted_terms_at;

// null
$user->is_subscribed_to_newsletter;
```

### Array conversion

When converting a model to an array, the boolean fields will be included if you've added them to the `$appends` array in your model.

```php
$user = User::findOrFail(42);

$user->toArray();

/*
 * Which will return something like:
 * 
 * [
 *     'accepted_terms_at' => \Carbon\CarbonImmutable('2018-05-10 16:24:22'),
 *     'subscribed_to_newsletter_at' => \Illuminate\Support\Carbon('2018-05-10 16:24:22'),
 *     'has_accepted_terms' => true,
 *     'is_subscribed_to_newsletter' => true,
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

[version-badge]: https://img.shields.io/packagist/v/sebastiaanluca/laravel-boolean-dates.svg?label=stable
[license-badge]: https://img.shields.io/badge/license-MIT-informational.svg
[travis-badge]: https://img.shields.io/travis/sebastiaanluca/laravel-boolean-dates/master.svg
[downloads-badge]: https://img.shields.io/packagist/dt/sebastiaanluca/laravel-boolean-dates.svg?color=brightgreen
[stars-badge]: https://img.shields.io/github/stars/sebastiaanluca/laravel-boolean-dates.svg?color=brightgreen

[blog-link-badge]: https://img.shields.io/badge/link-blog-lightgrey.svg
[packages-link-badge]: https://img.shields.io/badge/link-other_packages-lightgrey.svg
[twitter-profile-badge]: https://img.shields.io/twitter/follow/sebastiaanluca.svg?style=social
[twitter-share-badge]: https://img.shields.io/twitter/url/http/shields.io.svg?style=social

[link-github]: https://github.com/sebastiaanluca/laravel-boolean-dates
[link-packagist]: https://packagist.org/packages/sebastiaanluca/laravel-boolean-dates
[link-travis]: https://travis-ci.org/sebastiaanluca/laravel-boolean-dates
[link-twitter-share]: https://twitter.com/intent/tweet?text=Easily%20convert%20Eloquent%20model%20booleans%20to%20dates%20and%20back%20with%20Laravel%20Boolean%20Dates.%20Via%20@sebastiaanluca%20https://github.com/sebastiaanluca/laravel-boolean-dates
[link-contributors]: ../../contributors

[link-portfolio]: https://sebastiaanluca.com
[link-blog]: https://sebastiaanluca.com/blog
[link-packages]: https://packagist.org/packages/sebastiaanluca
[link-twitter]: https://twitter.com/sebastiaanluca
[link-github-profile]: https://github.com/sebastiaanluca
[link-author-email]: mailto:hello@sebastiaanluca.com
