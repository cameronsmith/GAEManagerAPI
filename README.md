# Google App Engine Manager API
Google App Engine Manager allows customized building of app engines.

### Testing

You'll need datastore emulator installed to run the integration tests. If you do not have the emulator already installed 
you will need to run the command:

```bash
gcloud components install cloud-datastore-emulator
```

To run tests you'll need to run the datastore emulator by doing the following command:
```bash
composer run datastore_emulator --timeout=0
```

You can now run the tests locally by using the command:
```bash
./vendor/bin/phpunit
```
