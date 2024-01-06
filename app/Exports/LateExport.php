<?php

namespace App\Exports;

use App\Models\Late;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Retrieve data from the database
        $lates = Late::with('student')->get();

        // Create a map to store unique student IDs and their corresponding names
        $studentNames = [];

        // Map the data to the desired columns
        $data = $lates->map(function ($late) use (&$studentNames) {
            // Check if the student ID is already in the map
            if (!isset($studentNames[$late->student->id])) {
                // If not, add the student ID and name to the map
                $studentNames[$late->student->id] = $late->student->name;

                // Return the data for this row
                return [
                    'NIS' => $late->student->nis,
                    'Nama' => $late->student->name,
                    'Rombel' => $late->student->rombel->rombel, // Access the 'rombel' property
                    'Rayon' => $late->student->rayon->rayon, // Access the 'rayon' property
                    'Jumlah Keterlambatan' => $this->getJumlahKeterlambatan($late->student->id),
                ];
            }

            // If the student ID is already in the map, return null for this row
            return null;
        })->filter(); // Filter out null values

        return $data;
    }

    public function headings(): array
    {
        return [
            "Nis", "Nama", "Rombel", "Rayon", "Jumlah Keterlambatan"
        ];
    }

    protected function getJumlahKeterlambatan($studentId)
    {
        return DB::table('lates')
            ->where('student_id', $studentId)
            ->count();
    }
}
