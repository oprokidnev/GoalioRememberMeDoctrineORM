# GoalioRememberMeDoctrine module.

Automatically detects doctrine orm or odm module in your application and registers appropriate storage for GoalioRememberMe module.

## Usage

```php
//application.config.php
return [
    'modules' => array(
        'GoalioRememberMe',
        'GoalioRememberMeDoctrineORM', //!insert module here
    ),
];
```

To use non-default doctrine object manager please point it in the application config.

```php
//config/autoload/application.local.php
return [
    /**
     * Some other modules
     */
     
    'goaliorememberme_doctrine' => [
        'object_manager' => 'doctrine.entity_manager.orm_default',
                      // or 'doctrine.document_manager.odm_default',
    ],
];
```
