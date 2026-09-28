<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'nis' => '2406510564',
                'name' => 'AKBAR MIRAI NUGRAHA',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510566',
                'name' => 'ARI NURJAMAN',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510570',
                'name' => 'BILY ALBANI MAHENDRA',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510571',
                'name' => 'BINTANG PUTRA SEFIYAN',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510573',
                'name' => 'DENIS NURIZKI',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510574',
                'name' => 'DHAFIN SYAWAL ANUGERAH',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510577',
                'name' => 'FADHIL AHLFADZH',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510581',
                'name' => 'FERLY JULIAN',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510582',
                'name' => 'FHAIZA SOPIYANA',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510583',
                'name' => 'FITRA HERDIANSYAH FADLURROHMAN',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510584',
                'name' => 'GALANG AULIA AL BUKHORI',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510588',
                'name' => 'HENGKY TERNANDO',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510589',
                'name' => 'JAVIER DELIAN ARYATAMA',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510592',
                'name' => 'KEYSA CITRA PUSPITASARI',
                'gender' => 'P',
                'phone' => null,
            ],
            [
                'nis' => '2406510595',
                'name' => 'KHUMAIRA MAHESWARI',
                'gender' => 'P',
                'phone' => null,
            ],
            [
                'nis' => '2406510597',
                'name' => 'MEDYNA JUNISTIA MUMTAZA',
                'gender' => 'P',
                'phone' => null,
            ],
            [
                'nis' => '2406510601',
                'name' => 'MUHAMAD RIZKI ANDIKA',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510603',
                'name' => 'MUHAMMAD DWI FEBRIAN AL FATH',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510606',
                'name' => 'MUHAMMAD FARGAN HABIBURROHMAN',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510607',
                'name' => 'MUHAMMAD KHOERUL FATHURROHMAN',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510605',
                'name' => 'MUHAMMAD RIZQI BINTANG RAMADHAN',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510609',
                'name' => 'MUSTIKA KUSUMAPRIANGAN',
                'gender' => 'P',
                'phone' => null,
            ],
            [
                'nis' => '2406510610',
                'name' => 'NAZMI SEPTIANSAH',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510611',
                'name' => 'NAZWA NURHAFIZA',
                'gender' => 'P',
                'phone' => null,
            ],
            [
                'nis' => '2406510615',
                'name' => 'PUTRI AYU LESTARI',
                'gender' => 'P',
                'phone' => null,
            ],
            [
                'nis' => '2406510616',
                'name' => 'RAFFA PRATAMA PUTRA',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510620',
                'name' => 'REIZA RAHMAWARDANA',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510623',
                'name' => 'SAEFUL ROHMAN',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510628',
                'name' => 'SYAWAL NURRAHMAN',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510631',
                'name' => 'TSABIT AQIL MUBAROK',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510632',
                'name' => 'YOGA AKSHAYA PRATAMA',
                'gender' => 'L',
                'phone' => null,
            ],
            [
                'nis' => '2406510633',
                'name' => 'YONATAN HIDAYAT',
                'gender' => 'L',
                'phone' => null,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}