<?php

use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialties')->insertOrIgnore([
            [
                'id' => 11,
                'name' => 'Allergy and Immunology',
                'acronym' => 'ALGC',
                'description' => 'The medical specialty of Allergy and Immunology focuses on the diagnosis and treatment of allergies.',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 12,
                'name' => 'Anesthesiology',
                'acronym' => 'ANSLG',
                'description' => 'Anesthesiology is the medical specialty focusing on administering pain-killing drugs during surgery in the operating room. Anesthesiology also includes the field of Pain Management, a sub-specialty which helps manage chronic (ongoing) pain in patients with prescription medication, injections, or other therapeutic methods.',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 13,
                'name' => 'Dermatology',
                'acronym' => 'DMLG',
                'description' => 'The field of dermatology focuses on the diagnosis, treatment, and prevention of diseases, disorders, and conditions of the skin.',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 14,
                'name' => 'Family Medicine',
                'acronym' => 'FM',
                'description' => 'Family medicine is a primary care field overseeing the basic healthcare needs of patients of all ages, from infant to geriatric.',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 15,
                'name' => 'Ophthalmology',
                'acronym' => 'OPLG',
                'description' => 'Ophthalmology is the medical specialty focusing on treatment of the eyes, and retina. Not to be confused with an optometrist, ophthalmologists can also do eye surgery and prescribe medication unlike optometrists, who typically focus on eyesight correction and enhancement and prescription lenses.',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 16,
                'name' => 'Otolaryngology - ENT',
                'acronym' => 'ENT',
                'description' => 'Otolaryngology is the medical specialty commonly known as “E.N.T.”, which stands for ear, nose, and throat. Otolaryngology includes office-based care, and surgical procedures both in the hospital and in the office. Therefore, a variety of practice environments and employers are available in this field.',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 17,
                'name' => 'Psychiatry',
                'acronym' => 'PSY',
                'description' => 'Psychiatry entails the treatment of patients’ mental health and well-being. Psychiatry may be practiced in an office, providing psychotherapy and medication for more common psychiatric care, or in a psychiatric hospital for more serious, acute psychiatric issues such as bipolar disorder, schizophrenia, and other issues requiring hospitalization. Psychiatry also involves treatment of patients with addictions such as drugs or alcohol.',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
        ]);

    }
}
