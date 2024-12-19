<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    // Display the backup page with download and upload options
    public function index()
    {
        return view('/backup');
    }

    // Handle the database backup download

    public function download()
    {
        try {
            // Set the file name for the backup
            $backupFileName = 'backup_tms_' . now()->format('Y_m_d_H_i_s') . '.sql';
            
            $backupFilePath = storage_path('app/backups/' . $backupFileName);
    
            // Check if the backup directory exists or create it
            $backupDir = storage_path('app/backups');
            if (!File::exists($backupDir)) {
                if (!File::makeDirectory($backupDir, 0755, true)) {
                    throw new \Exception("Failed to create directory: $backupDir");
                }
            }
    
            // Prepare SQL content
            $sqlContent = "-- Database Backup (Visitor and Survey Responses Tables)\n-- Generated on " . now()->toDateTimeString() . "\n\n";
    
            // Define the table names to back up
            $tables = ['visitors', 'survey_responses']; // List the tables you want to back up
    
            foreach ($tables as $tableName) {
                // Get CREATE TABLE statement for the current table
                $createTableQuery = DB::select("SHOW CREATE TABLE `$tableName`");
                $createTableStatement = $createTableQuery[0]->{'Create Table'};
    
                // Modify CREATE TABLE to include IF NOT EXISTS
                $createTableStatement = preg_replace('/CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $createTableStatement);
                $sqlContent .= $createTableStatement . ";\n\n";
    
                // Get table rows for the current table
                $rows = DB::table($tableName)->get();
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $columns = [];
                    $values = [];
    
                    // Prepare columns and values for the INSERT, excluding auto-increment `id` column
                    foreach ($rowArray as $column => $value) {
                        if (strtolower($column) !== 'id') {  // Skip the 'id' column
                            $columns[] = "`$column`";
                            $values[] = is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                        }
                    }
    
                    // Generate the INSERT statement for the current row
                    $sqlContent .= "INSERT IGNORE INTO `$tableName` (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ");\n";
                }
                $sqlContent .= "\n";
            }
    
            // Save the SQL content to a file
            if (File::put($backupFilePath, $sqlContent)) {
                \Log::info('Backup successfully created: ' . $backupFilePath);
            } else {
                \Log::error('Failed to write backup file: ' . $backupFilePath);
            }
    
            // Download the file
            return response()->download($backupFilePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error('Backup failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate backup: ' . $e->getMessage()], 500);
        }
    }
    
    

    

    // Handle the database restore from uploaded SQL file
    public function showUploadForm()
    {
        return view('upload_sql'); // This will be the view for the upload form
    }
    
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'sql_file' => [
                'required',
                'file',
                function ($attribute, $value, $fail) use ($request) {
                    $file = $request->file('sql_file');
                    if ($file && $file->getClientOriginalExtension() !== 'sql') {
                        $fail('The ' . $attribute . ' must be a file of type: sql.');
                    }
                },
            ],
        ]);
    
        // Store the file temporarily
        $path = $request->file('sql_file')->storeAs('sql_backup', 'backup_' . time() . '.sql');
        $fullPath = storage_path('app/' . $path);
    
        // Read the file contents
        $sql = File::get($fullPath);
    
        // Parse SQL statements
        $statements = explode(';', $sql); // Split SQL by statement delimiters
    
        // First, truncate the 'visitor' and 'survey_responses' tables to remove old data
        DB::table('visitors')->truncate();  // Remove all old records from the 'visitor' table
        DB::table('survey_responses')->truncate();  // Remove all old records from the 'survey_responses' table
    
        foreach ($statements as $statement) {
            $trimmedStatement = trim($statement);
    
            // Skip empty or invalid statements
            if (empty($trimmedStatement)) {
                continue;
            }
    
            if (str_starts_with(strtolower($trimmedStatement), 'insert into')) {
                // Execute the INSERT statement to add new data
                DB::unprepared($trimmedStatement);
            } else {
                // Execute non-INSERT statements directly (e.g., ALTER, UPDATE, etc.)
                DB::unprepared($trimmedStatement);
            }
        }
    
        // Delete the temporary file
        File::delete($fullPath);
    
        return redirect()->back()->with('success', 'Database backup file uploaded and processed successfully!');
    }
    
    
    
}
