<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Quiz;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{
    public function index()
    {
        return view("dashboard", [
            "types" => Type::all(),
            "quizTotalCount" => Quiz::count(),
            "paperCount" => Paper::count(),
            "latest8papers" => Paper::latest('updated_at')->take(5)->get()
        ]);
    }

    public function exportDatabase()
    {
        // Specify the desired order of table creation
        // Specify the order of table creation including Laravel's default tables
        $tableOrder = [
            'migrations', 'failed_jobs', 'password_reset_tokens', 'personal_access_tokens', 'users',
            'types',
            'quizzes',
            'settings',
            'papers',
            'paper_quiz'    
        ];

        // Get all table names in the database
        $tables = DB::select('SHOW TABLES');

        // Initialize an empty SQL string to store export content
        $sql = '';

        // Add table creation order metadata
        $sql .= "-- Table Creation Order: " . implode(', ', $tableOrder) . "\n\n";

        foreach ($tableOrder as $tableName) {
            // Get table structure
            $tableStructure = DB::select("SHOW CREATE TABLE $tableName");
            $createTableStatement = $tableStructure[0]->{"Create Table"};

            // Get table data
            $tableData = DB::table($tableName)->get()->toArray();

            // Add DROP TABLE IF EXISTS statement
            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";

            // Add CREATE TABLE statement
            $sql .= "$createTableStatement;\n";

            // Add INSERT INTO statements for table data
            foreach ($tableData as $row) {
                $rowValues = implode("', '", (array) $row);
                $sql .= "INSERT INTO `$tableName` VALUES ('$rowValues');\n";
            }

            // Add separator between tables
            $sql .= "\n";
        }

        // Generate a unique file name for the SQL export
        $fileName = 'database_export_' . date('Y-m-d_H-i-s') . '.sql';

        // Write SQL content to a file in the storage directory
        File::put(storage_path('app/' . $fileName), $sql);

        // Download the generated SQL file
        return response()->download(storage_path('app/' . $fileName))->deleteFileAfterSend();
    }

    public function importDatabase(Request $request)
    {
        // $this->validate($request, [
        //     'importDatabase' => 'required|mimes:sql'
        // ]);

        $filePath = $request->file('importDatabase')->getRealPath();
        $sql = file_get_contents($filePath);

        // Drop all tables
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = reset($table);
            DB::statement("DROP TABLE IF EXISTS `$tableName`");
        }

        // Import SQL file
        DB::unprepared($sql);

        return redirect()->back()->with('success', 'Database imported successfully.');
    }
}
