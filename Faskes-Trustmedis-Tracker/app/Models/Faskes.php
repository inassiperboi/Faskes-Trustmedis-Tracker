<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faskes extends Model
{
    protected $table = 'faskes';

    protected $fillable = [
        'nama',
        'penanggung_jawab',
        'tim',
        'catatan', // replaced progress with catatan
    ];

    /**
     * Relasi Faskes -> Master
     * Satu faskes punya banyak master
     */
    public function masters()
    {
        return $this->hasMany(Master::class, 'faskes_id');
    }

    public function tahapan()
    {
        return $this->hasMany(Master::class, 'faskes_id');
    }

    /**
     * Helper untuk menghitung statistik progress
     * Mengembalikan array ['total' => int, 'completed' => int]
     */
    public function getProgressStats()
    {
        // Ambil semua masters dari faskes ini dengan eager loading
        $masters = $this->masters()->with(['submasters.subsections'])->get();
        
        $totalItems = 0;
        $completedItems = 0;
        
        // Loop through setiap master
        foreach ($masters as $master) {
            // Loop through setiap sub_master
            foreach ($master->submasters as $subMaster) {
                $totalItems++;
                
                // Cek jika sub_master status = 'selesai'
                if ($subMaster->status === 'selesai') {
                    $completedItems++;
                }
                
                // Loop through setiap sub_section
                foreach ($subMaster->subsections as $subSection) {
                    $totalItems++;
                    
                    // Cek jika sub_section status = 'selesai'
                    if ($subSection->status === 'selesai') {
                        $completedItems++;
                    }
                }
            }
        }

        return [
            'total' => $totalItems,
            'completed' => $completedItems
        ];
    }

    /**
     * Menghitung persentase progress berdasarkan status submit selesai
     * dari sub_master dan sub_section
     * 
     * @return float
     */
    public function getProgressPercentageAttribute()
    {
        $stats = $this->getProgressStats();
        
        // Jika tidak ada item sama sekali, return 0
        if ($stats['total'] === 0) {
            return 0;
        }
        
        // Hitung persentase: (selesai / total) * 100
        return round(($stats['completed'] / $stats['total']) * 100, 2);
    }

    /**
     * Mengambil total item (sub_master + sub_section)
     */
    public function getTotalProgressItems()
    {
        return $this->getProgressStats()['total'];
    }

    /**
     * Mengambil jumlah item yang selesai
     */
    public function getCompletedProgressItems()
    {
        return $this->getProgressStats()['completed'];
    }
}
