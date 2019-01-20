# laravel-pgsql-trigger-helper
Simple Helper to create Postgresql trigger in Laravel migration file

# Installation:

copy plsql_helper.php to App/Helper directory, if Helper directory does not exist, create first by your self.

# Usage

make migration file using artisan as usual
    
    php artisan make:migration NAME_OF_YOUR_MIGRATION

use Plsql helper inside migration file

    use App\Helpers\Plsql\Plsql as trigger;

declare your table that will use the trigger
    
    $mytrigger = trigger::table("tb_user")

Add the the primary and optional parameters to create trigger.
These are the options:

    before('insert') OR after('insert') // MUST
    declare([['variable1'=>'integer'],['variable2'=>'integer']]) // OPTIONAL
    begin("new.nama:='new_name'") // MUST -- EXAMPLE CODE STRING
    whenOr("new.nama <> '4'") // EXAMPLE WHEN CONDITIONAL PARAMETER USING OR
    when("new.nama <> '2'") // EXAMPLE WHEN CONDITIONAL PARAMETER USING AND
    create(); // MUST
    
 Next, do laravel DB unprepared   
    
    DB::unprepared($mytrigger);
    
 # Conclusion
You can see the simple attached migration file to expand the usage.
You can also customize the helper by your own implementation to ease your job in creating plsql command to POSTGRESQL DB.
Happy coding ^_^ just do simple thing as can as possible.
