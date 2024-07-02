# sulu-securitytxt-bundle

[![Mastodon Follow](https://img.shields.io/mastodon/follow/109408681246972700?domain=https://rheinneckar.social)](https://rheinneckar.social/@bitexpert)

This is a Sulu Bundle to manage security.txt files for your Sulu webspaces.

According to [securitytxt.org](https://securitytxt.org) the main purpose of security.txt is to help make things easier for companies and security researchers when trying to secure platforms. Thanks to security.txt, security researchers can easily get in touch with companies about security issues.

## Installation

```bash
composer require bitexpert/sulu-securitytxt-bundle
```

1. Register the bundle in the file `config/bundles.php`
```php
BitExpert\Sulu\SecuritytxtBundle\BitExpertSuluSecuritytxtBundle::class => ['all' => true],
```

2. Configure the routing as follows:

Create file `config/routes/securitytxt_admin.yaml`:
```yaml
securitytxt_api:
    resource: "@BitExpertSuluSecuritytxtBundle/Resources/config/routing_api.yaml"
    type: rest
    prefix:   /admin/api
```

Create file `config/routes/securitytxt_website.yaml`:
```yaml
securitytxt_website:
  resource: "@BitExpertSuluSecuritytxtBundle/Resources/config/routing_website.yaml"
```

3. Run Doctrine Schema Update
```bash
./bin/adminconsole doctrine:schema:update -f
```

## Usage

Once installed, this bundle adds a tab called "Security.txt" to the webspaces configuration which allows you to create
new security.txt entries for the different webspaces. For each webspace only one security.txt configuration can be saved.

Since 0.5.0: Only users with the Securitytxt permissions can view, add, edit or delete the security.txt entries.

## Contribute

Please feel free to fork and extend existing or add new features and send a pull request with your changes! To establish
a consistent code quality, please provide unit tests for all your changes and adapt the documentation.

## Want To Contribute?

If you feel that you have something to share, then we’d love to have you.
Check out [the contributing guide](CONTRIBUTING.md) to find out how, as well as what we expect from you.

## License

Sulu Security.txt Bundle is released under the MIT License.
