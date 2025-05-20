<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add IT-related courses for a specific user (e.g., user with ID 1)
        $userId = User::first()->id; // Get the first user or use any user ID you prefer

        Course::create([
            'user_id' => $userId,
            'code' => 'CS101',
            'subject_title' => 'Introduction to Computer Science',
            'units_lab' => 3,
            'units_lecture' => 3,
            'credit' => 6,
            'description' => 'This course covers the basics of computer science, including algorithms, data structures, and programming languages.',
        ]);

        Course::create([
            'user_id' => $userId,
            'code' => 'CS102',
            'subject_title' => 'Object-Oriented Programming',
            'units_lab' => 2,
            'units_lecture' => 3,
            'credit' => 5,
            'description' => 'This course focuses on object-oriented programming principles and practices using a programming language like Java or C++.',
        ]);

        Course::create([
            'user_id' => $userId,
            'code' => 'CS103',
            'subject_title' => 'Data Structures and Algorithms',
            'units_lab' => 3,
            'units_lecture' => 3,
            'credit' => 6,
            'description' => 'A deeper dive into the study of data structures and algorithms to improve problem-solving skills and efficiency.',
        ]);

        Course::create([
            'user_id' => $userId,
            'code' => 'CS104',
            'subject_title' => 'Database Management Systems',
            'units_lab' => 2,
            'units_lecture' => 3,
            'credit' => 5,
            'description' => 'This course introduces the fundamental concepts of database design and management, SQL queries, and relational databases.',
        ]);

        Course::create([
            'user_id' => $userId,
            'code' => 'CS105',
            'subject_title' => 'Web Development',
            'units_lab' => 3,
            'units_lecture' => 3,
            'credit' => 6,
            'description' => 'This course teaches the basics of web development, including front-end technologies (HTML, CSS, JavaScript) and back-end development.',
        ]);

        Course::create([
            'user_id' => $userId,
            'code' => 'CS106',
            'subject_title' => 'Operating Systems',
            'units_lab' => 2,
            'units_lecture' => 3,
            'credit' => 5,
            'description' => 'A course on the principles of operating systems, including memory management, file systems, and process management.',
        ]);

        Course::create([
            'user_id' => $userId,
            'code' => 'CS107',
            'subject_title' => 'Software Engineering',
            'units_lab' => 3,
            'units_lecture' => 3,
            'credit' => 6,
            'description' => 'This course focuses on software development methodologies, including Agile, software testing, and project management.',
        ]);

        Course::create([
            'user_id' => $userId,
            'code' => 'CS108',
            'subject_title' => 'Computer Networks',
            'units_lab' => 2,
            'units_lecture' => 3,
            'credit' => 5,
            'description' => 'This course introduces the fundamentals of computer networks, including network topologies, protocols, and security.',
        ]);

        Course::create([
            'user_id' => $userId,
            'code' => 'CS109',
            'subject_title' => 'Artificial Intelligence',
            'units_lab' => 2,
            'units_lecture' => 3,
            'credit' => 5,
            'description' => 'This course covers the basics of AI, including search algorithms, machine learning, and neural networks.',
        ]);

        Course::create([
            'user_id' => $userId,
            'code' => 'CS110',
            'subject_title' => 'Mobile Application Development',
            'units_lab' => 3,
            'units_lecture' => 3,
            'credit' => 6,
            'description' => 'This course teaches the basics of mobile app development for Android and iOS platforms.',
        ]);
    }
}