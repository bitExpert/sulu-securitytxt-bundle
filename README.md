# sulu-securitytxt-bundle

Sulu Bundle to manage security.txt information

## Installation:

```bash
composer require bitexpert/sulu-securitytxt-bundle:dev-main
```

Register bundle in the file `config/bundles.php`
```php
BitExpert\Sulu\SecuritytxtBundle\BitExpertSuluSecuritytxtBundle::class => ['all' => true],
```

Create file `config/packages/securitytxt.yaml`:
```yaml
sulu_admin:
    resources:
        securitytxt:
            routes:
                list: app.get_securitytxt_list
                detail: app.get_securitytxt

```

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
