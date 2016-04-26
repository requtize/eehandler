# EEHandler
PHP Error and Exception Handler

```php
// Development environment - shows all errors and debug tools
$handler = new EEHandler('dev');

// Production environment - Show only HTTP error code.
$handler = new EEHandler('prod');

// Register all handlers
$handler->register();
```
