<?php
declare(strict_types=1);

/**
 * Seed 100 sample bookings.
 * Run:  "C:\xampp\php\php.exe" admin\database\seeds\seed_bookings.php
 * Flags:
 *   --count=N   (default 100)
 *   --truncate  (delete all existing bookings first)
 */

$cfg = require __DIR__ . '/../../config/database.php';

$args = [];
foreach ($argv as $a) {
    if (preg_match('/^--([^=]+)(?:=(.*))?$/', $a, $m)) {
        $args[$m[1]] = $m[2] ?? true;
    }
}
$count    = isset($args['count']) ? max(1, (int) $args['count']) : 100;
$truncate = !empty($args['truncate']);

try {
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $cfg['host'],
        $cfg['port'] ?? '3306',
        $cfg['database']
    );
    $pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (Throwable $e) {
    fwrite(STDERR, "Could not connect: " . $e->getMessage() . PHP_EOL);
    exit(1);
}

// ── data pools ───────────────────────────────────────────────────────────────
$firstNames = [
    'Aarav','Vihaan','Aditya','Arjun','Rohan','Ishaan','Kabir','Reyansh','Veer','Yash',
    'Krishna','Pranav','Rahul','Karan','Amit','Vikram','Suresh','Manoj','Aryan','Dev',
    'Siddharth','Aniket','Mohit','Nikhil','Tarun','Sahil','Harsh','Ankit','Varun','Rajat',
    'Aanya','Diya','Ananya','Saanvi','Aadhya','Pari','Riya','Anika','Myra','Kiara',
    'Ira','Navya','Sara','Tanvi','Meera','Isha','Priya','Neha','Pooja','Sneha',
    'Shruti','Kavya','Tanya','Megha','Nisha','Ritu','Ayesha','Sakshi','Divya','Rhea',
];
$lastNames = [
    'Sharma','Verma','Patil','Deshmukh','Joshi','Iyer','Kulkarni','Mehta','Shah','Agarwal',
    'Gupta','Singh','Khan','Reddy','Chaudhary','Bansal','Kapoor','Malhotra','Saxena','Tiwari',
    'Nair','Pillai','Rao','Bhatia','Jain','Sinha','Ghosh','Das','Roy','Yadav',
    'Choudhary','Kumar','Pandey','Mishra','Trivedi','Goel','Soni','Khanna','Dubey','Bhardwaj',
];
$services = [
    'Beginner Wheel Throwing Workshop',
    'Hand-Building Class',
    'Kids Pottery Camp',
    'Corporate Team Workshop',
    'Couples Pottery Experience',
    'Custom Ceramic Order',
    'Glazing Workshop',
    'Advanced Wheel Throwing',
    'Sculpture Workshop',
    'General Enquiry',
];
$times = ['10:00 AM','11:00 AM','11:30 AM','12:00 PM','2:00 PM','3:00 PM','4:00 PM','4:30 PM','5:30 PM','6:00 PM'];
$areas = ['Sai Nagar','Rajapeth','Camp Area','Badnera Road','Walgaon Road','Frezarpura','Gadge Nagar','Tarkheda','Khaparde Garden','Vidya Nagar'];
$cities = ['Amravati','Nagpur','Akola','Yavatmal','Wardha','Pune','Mumbai','Aurangabad'];
$sources = ['website','website','website','website','admin','phone','walk_in']; // website-weighted
$messages = [
    'Looking forward to my first pottery session!',
    'Is this suitable for beginners?',
    'Want to gift this to my partner for our anniversary.',
    'Planning a small team outing — please confirm slots.',
    'Can I bring a friend along?',
    'Do you provide aprons or should I bring my own?',
    'Is parking available near the studio?',
    'Need an early-morning slot if possible.',
    'My child is 8 — is this age-appropriate?',
    'Can the session be conducted in Marathi?',
    'Want to learn glazing techniques specifically.',
    'Interested in a long-term course, not just one session.',
    '',
    '',
    '',
];
$notesPool = [
    'Walk-in — paid in cash.',
    'Confirmed via WhatsApp.',
    'Returning customer.',
    'Birthday celebration — bring small cake.',
    'Asked to be seated near the wheel.',
    'Allergic to certain glazes — flagged.',
    'Confirmed via phone call.',
    '',
    '',
    '',
];

// status weights based on date relative to today
function pickStatus(string $date, string $today): string {
    if ($date < $today) {
        // past: mostly completed
        $r = mt_rand(1, 100);
        if ($r <= 70) return 'completed';
        if ($r <= 82) return 'cancelled';
        if ($r <= 92) return 'no_show';
        return 'confirmed';
    } elseif ($date === $today) {
        $r = mt_rand(1, 100);
        return $r <= 60 ? 'confirmed' : ($r <= 90 ? 'pending' : 'cancelled');
    } else {
        // future: pending / confirmed
        $r = mt_rand(1, 100);
        if ($r <= 55) return 'pending';
        if ($r <= 90) return 'confirmed';
        return 'cancelled';
    }
}

function pick(array $a) { return $a[array_rand($a)]; }

if ($truncate) {
    echo "Deleting existing bookings…" . PHP_EOL;
    $pdo->exec("DELETE FROM bookings");
}

$sql = "INSERT INTO bookings
    (customer_name, phone, email, dob, address, service, preferred_date, preferred_time,
     message, status, notes, source, created_at, updated_at)
    VALUES
    (:customer_name, :phone, :email, :dob, :address, :service, :preferred_date, :preferred_time,
     :message, :status, :notes, :source, :created_at, :updated_at)";
$stmt = $pdo->prepare($sql);

$today = date('Y-m-d');
$inserted = 0;

$pdo->beginTransaction();
try {
    for ($i = 1; $i <= $count; $i++) {
        $first = pick($firstNames);
        $last  = pick($lastNames);
        $name  = "$first $last";

        // Phone: starts with 7/8/9
        $phone = '+91 ' . pick(['7','8','9']) . str_pad((string) mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT);

        // Email: 60% of rows
        $hasEmail = mt_rand(1, 100) <= 75;
        $email = $hasEmail
            ? strtolower($first . '.' . $last . mt_rand(1, 99)) . '@' . pick(['gmail.com','yahoo.com','outlook.com','hotmail.com'])
            : null;

        // DOB: 40% have one, age 8-55
        $dob = mt_rand(1, 100) <= 40
            ? date('Y-m-d', strtotime('-' . mt_rand(8, 55) . ' years -' . mt_rand(0, 364) . ' days'))
            : null;

        // Address: 55% have one
        $address = mt_rand(1, 100) <= 55
            ? mt_rand(1, 250) . ', ' . pick($areas) . ', ' . pick($cities)
            : null;

        $service = pick($services);

        // preferred_date: range from -150 days to +90 days
        $offset = mt_rand(-150, 90);
        $preferredDate = date('Y-m-d', strtotime("$today $offset days"));
        $preferredTime = pick($times);

        $message = pick($messages);
        $status  = pickStatus($preferredDate, $today);
        $notes   = pick($notesPool);
        $source  = pick($sources);

        // created_at: a little before the preferred_date (1–14 days)
        $createdOffset = mt_rand(1, 14);
        $createdAt = date('Y-m-d H:i:s', strtotime("$preferredDate -$createdOffset days +" . mt_rand(0, 86399) . " seconds"));
        $updatedAt = $status === 'pending'
            ? $createdAt
            : date('Y-m-d H:i:s', strtotime("$createdAt +" . mt_rand(1, 10) . " days"));

        $stmt->execute([
            ':customer_name'  => $name,
            ':phone'          => $phone,
            ':email'          => $email,
            ':dob'            => $dob,
            ':address'        => $address,
            ':service'        => $service,
            ':preferred_date' => $preferredDate,
            ':preferred_time' => $preferredTime,
            ':message'        => $message === '' ? null : $message,
            ':status'         => $status,
            ':notes'          => $notes === '' ? null : $notes,
            ':source'         => $source,
            ':created_at'     => $createdAt,
            ':updated_at'     => $updatedAt,
        ]);
        $inserted++;
    }
    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, "Insert failed: " . $e->getMessage() . PHP_EOL);
    exit(1);
}

echo "Inserted $inserted booking(s) into `bookings`." . PHP_EOL;
