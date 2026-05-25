<?php
session_start();

//grap data from sesseions
$_name = $_SESSION['name'] ?? 'no name recieved';
$_level = $_SESSION['level'] ?? '-';
$_sex = $_SESSION['sex'] ?? '-';
$_matricule = $_SESSION['matricule'] ?? '-';
$_department = $_SESSION['department'] ?? '-';
$_photo = $_SESSION['photo_base64'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background:
                radial-gradient(circle at top right, rgba(191, 219, 254, 0.55), transparent 30%),
                linear-gradient(135deg, #eef5ff 0%, #f8fbff 48%, #eaf3ff 100%);
        }

        .menu-bar {
            background-color: #ffffff;
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            padding: 0 40px;
            box-sizing: border-box;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            font-weight: 700;
            color: #1e293b;
            font-size: 1.2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .dashboard-icon :hover {
            color: #9bbcff;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            z-index: 1001;
            background-color: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: calc(100vh - 50px);
            width: 200px;
        }

        .dropdown-content ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .dropdown-content li {
            color: #1d4ed8;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 10px;
        }

        .dropdown-content li:hover {
            background-color: #e2e8f0;
        }

        .dropdown-content .logout {
            color: #ef4444;
        }

        .dropdown-content .logout:hover {
            background-color: #b91c1c30;
        }

        .heading {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            text-align: center;
        }

        .icon-box {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: #dbeafe;
            color: #1d4ed8;
            display: grid;
            place-items: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        .heading h1 {
            margin: 0;
            font-size: 2rem;
            color: #0f172a;

        }

        .subtitle {
            color: #64748b;
            text-align: center;
            margin-bottom: 20px;
        }

        .page-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            transition: opacity 0.3s ease, filter 0.3s ease;
        }
        body.menu-open .page-content {
            opacity: 0.7;
            filter: blur(2px);
            pointer-events: none;
        }
        body.menu-open .dropdown-content {
            display: block;
        }

        .id-card {
            width: min(100%, 380px);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(30, 64, 175, 0.18);
            background: white;
        }

        .card-header {
            background: linear-gradient(135deg, #1e40af, #2563eb, #3b82f6);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            height: 40px;
        }

        .logo-circle img {
            width: 50px;
            height: 80px;
            margin-top: 15px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .card-subtitle {
            font-size: 11px;
            opacity: 0.8;
            margin-top: 2px;
        }

        .card-body {
            padding: 18px 24px;
            display: flex;
            gap: 18px;
        }

        .photo {
            width: 80px;
            height: 96px;
            border-radius: 10px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border: 2px solid #93c5fd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            font-size: 12px;
            flex-shrink: 0;
        }

        .photo img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
           
        }

        .info {
            flex: 1;
            min-width: 0;
        }

        .student-name {
            font-weight: 700;
            font-size: 17px;
            color: #1e3a5f;
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .info-row .label {
            color: #6b7280;
            width: 50px;
            font-weight: 500;
        }

        .info-row .value {
            color: #1e3a5f;
            font-weight: 600;
        }

        .card-footer {
            background: linear-gradient(90deg, #1e40af, #2563eb);
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            font-size: 10px;
        }

        .card-footer .footer-section {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .card-footer .label {
            opacity: 0.8;
            font-size: 9px;
        }

        .card-footer .value {
            font-weight: 600;
            font-size: 11px;
        }

        .download-btn {
            margin-top: 24px;
            background: linear-gradient(135deg, #1e40af, #2563eb);
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
        }

        .download-btn:hover {
            opacity: 0.95;
        }

        @media (max-width: 500px) {
            .menu-bar {
                padding: 0 20px;
            }

            .page-content {
                padding: 18px 12px;
            }

            .id-card {
                width: 100%;
            }

            .card-header {
                padding: 14px 16px;
                gap: 10px;
            }

            .card-title {
                font-size: 14px;
            }

            .card-subtitle {
                font-size: 10px;
            }

            .card-body {
                padding: 16px;
                gap: 14px;
                align-items: flex-start;
            }

            .photo {
                width: 78px;
                height: 94px;
            }

            .student-name {
                font-size: 15px;
                margin-bottom: 8px;
                overflow-wrap: anywhere;
            }

            .info-row {
                font-size: 11px;
                margin-bottom: 4px;
            }

            .info-row .label {
                width: 44px;
            }

            .card-footer {
                padding: 10px 16px;
                gap: 12px;
            }

            .logo-circle img {
                width: 40px;
                height: 64px;
            }

            .download-btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="menu-bar" onclick="toggleDropdown()">
        <div class="dashboard-icon" style="gap: 3px;"><i class="fa-solid fa-bars"></i></div>
        Dashboard
    </div>

    <div class="dropdown-content" id="dropdown-content">
        <ul>
            <li class="id" onclick="window.location.href = 'dashboard.html'"><i class="fa-solid fa-id-card"></i> Create
                ID</li>
            <li class="profile" onclick="window.location.href = 'card.php'"><i class="fa-solid fa-download"></i> Download ID
            </li>
            <li class="history" onclick="window.location.href = 'history.php'"><i class="fa-solid fa-clock"></i>
                History</li>
            <li class="logout" onclick="window.location.href = 'logout.php'"><i class="fa-solid fa-sign-out-alt"></i>
                Logout</li>
        </ul>
    </div>

    <div class="page-content">
        <div class="heading">
            <div class="icon-box"><i class="fa-solid fa-id-card"></i></div>
            <h1>Student ID Generator</h1>
        </div>
        <p class="subtitle">Fill in your details and generate a downloadable student ID card.</p>

        <div class="id-card" id="idCard">
            <div class="card-header">
                <div class="logo-circle">
                    <img src="cuib.png" alt="CUIB logo">
                </div>
                <div>
                    <div class="card-title">Catholic University of Buea</div>
                    <div class="card-subtitle">Official Identification</div>
                </div>
            </div>

            <div class="card-body">
                <div class="photo"> 
                    <?php if (!empty($_photo)): ?>
        <img src="<?php echo $_photo; ?>" alt="Student Photo">
    <?php else: ?>
        <span style="color: #94a3b8; font-size: 11px;">No Photo</span>
    <?php endif; ?>
                </div>
                <div class="info">
                  <!-- Dynamic Text Injections via PHP -->
                    <div class="student-name"><?php echo htmlspecialchars($_name); ?></div>
                    <div class="info-row"><span class="label">ID No.</span><span class="value"><?php echo htmlspecialchars($_matricule); ?></span></div>
                    <div class="info-row"><span class="label">Level</span><span class="value"><?php echo htmlspecialchars($_level); ?></span></div>
                    <div class="info-row"><span class="label">Dept.</span><span class="value"><?php echo htmlspecialchars($_department); ?></span></div>
                    <div class="info-row"><span class="label">Sex</span><span class="value"><?php echo htmlspecialchars($_sex); ?></span></div>
                </div>
            </div>

            <div class="card-footer">
                <div class="footer-section">
                    <span class="label">Valid for current academic session</span>
                    <span class="value">2026/2027</span>
                </div>
                <div class="footer-section">
                    <span class="label">Signed by</span>
                    <span class="value">President of CUIB</span>
                </div>
            </div>
        </div>

        <button class="download-btn" onclick="downloadCard()">⬇ Download ID Card</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function downloadCard() {
    // 1. Target the HTML card element container
    const card = document.getElementById('idCard');
    
    // 2. Fetch the student name safely from PHP to name the file automatically
    const studentName = '<?php echo str_replace(array("'", '"', ' '), '_', $_name); ?>';
    const filename = studentName + '_id_card.png';
    
    // 3. Run html2canvas with production-ready configuration flags
    html2canvas(card, {
        scale: 3,             // Triples the pixel resolution so text looks perfectly sharp on mobile/desktop
        useCORS: true,        // Allows local server assets (like your logo image) to load into the screenshot
        logging: false,       // Disables background console log spamming
        backgroundColor: null // Keeps the background around the rounded card corners transparent
    }).then(function (canvas) {
        // 4. Convert the canvas into a downloadable PNG Image Data URL
        const imgData = canvas.toDataURL('image/png');
        
        // 5. Create an invisible anchor (<a>) tag link in memory
        const downloadLink = document.createElement('a');
        downloadLink.href = imgData;
        downloadLink.download = filename;
        
        // 6. Programmatically trigger a click event to download the file directly to the device
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink); // Clean up memory
    }).catch(function (error) {
        console.error('Error generating high-quality image download:', error);
    });
}
       /* function downloadCard() {

            const card = document.getElementById('idCard');
            html2canvas(card, { scale: 3 }).then(function (canvas) {
                const link = document.createElement('a');
                link.download = 'student_id_card.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
            */

        function toggleDropdown() {
            var dropdown = document.getElementById('dropdown-content');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                document.body.classList.remove('menu-open');
            } else {
                dropdown.style.display = 'block';
                document.body.classList.add('menu-open');
            }
        }
    </script>
</body>

</html>
