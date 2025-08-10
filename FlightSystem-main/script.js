// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    console.log("JavaScript Loaded Successfully!");

    // === LANDING PAGE ===
    if (document.querySelector(".landing-container")) {
        console.log("Landing Page Loaded Successfully!");
        const buttons = document.querySelectorAll(".btn");
        buttons.forEach(button => {
            button.addEventListener("click", () => {
                button.classList.add("clicked");
                setTimeout(() => {
                    window.location.href = button.getAttribute("href");
                }, 300);
            });
        });
    }

    // === PASSENGER REGISTRATION PAGE ===
    if (document.getElementById("passengerRegisterForm")) {
        document.getElementById("passengerRegisterForm").addEventListener("submit", event => {
            event.preventDefault();
            const fullName = document.getElementById("fullName").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const phone = document.getElementById("phone").value.trim();

            if (!fullName || !email || !password || !phone) {
                alert("Please fill out all required fields.");
                return;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return;
            }

            const phonePattern = /^[0-9]{10,15}$/;
            if (!phonePattern.test(phone)) {
                alert("Please enter a valid phone number.");
                return;
            }

            alert("Registration successful! Redirecting to login page...");
            window.location.href = "login.php";
        });
    }

    // === LOGIN PAGE ===
    if (document.getElementById("loginForm")) {
        document.getElementById("loginForm").addEventListener("submit", event => {
            event.preventDefault();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();

            if (!email || !password) {
                alert("Please enter both email and password.");
                return;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return;
            }

            const urlParams = new URLSearchParams(window.location.search);
            const userType = urlParams.get("type");

            if (userType === "passenger") {
                alert("Login successful! Redirecting to Passenger Dashboard...");
                window.location.href = "passenger-dashboard.html";
            } else if (userType === "company") {
                alert("Login successful! Redirecting to Company Dashboard...");
                window.location.href = "company-dashboard.html";
            } else {
                alert("User type not specified. Please select from the landing page.");
            }
        });

        // Redirect "Register here" to the correct registration page based on user type
        const urlParams = new URLSearchParams(window.location.search);
        const userType = urlParams.get("type");
        const registerLink = document.getElementById("registerLink");

        if (userType === "passenger") {
            registerLink.href = "passenger-register.php"; // Redirect to Passenger Registration
        } else if (userType === "company") {
            registerLink.href = "company-register.php"; // Redirect to Company Registration
        } else {
            registerLink.href = "#"; // Fallback if no type is specified
            console.error("User type not specified.");
        }
    }

    // === COMPANY REGISTRATION PAGE ===
    if (document.getElementById("companyRegisterForm")) {
        console.log("Company Registration Page Loaded!");

        document.getElementById("companyRegisterForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            // Collecting Form Data
            const companyName = document.getElementById("companyName").value.trim();
            const bio = document.getElementById("bio").value.trim();
            const address = document.getElementById("address").value.trim();
            const location = document.getElementById("location").value.trim(); // Optional
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();
            const confirmPassword = document.getElementById("confirmPassword").value.trim();
            const email = document.getElementById("email").value.trim();
            const phone = document.getElementById("phone").value.trim();

            // Required Fields Validation
            if (!companyName || !bio || !address || !username || !password || !confirmPassword || !email || !phone) {
                alert("Please fill out all required fields.");
                return;
            }

            // Validate Password Match
            if (password !== confirmPassword) {
                alert("Passwords do not match. Please re-enter.");
                return;
            }

            // Validate Email Format
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return;
            }

            // Validate Phone Format
            const phonePattern = /^[0-9]{10,15}$/; // Accepts 10 to 15 digits
            if (!phonePattern.test(phone)) {
                alert("Please enter a valid phone number.");
                return;
            }

            // Success Message and Redirection
            alert("Registration successful! Redirecting to login page...");
            window.location.href = "login.php"; // Redirect to login page
        });
    }

   // JavaScript for the Company Home page
// Handle "Add Flight" button click
document.querySelector('.add-flight-btn').addEventListener('click', function() {
    alert('Redirecting to Add Flight page...');
    window.location.href = 'add-flight.php'; // Change this URL to your actual Add Flight page URL
});

// Handle "Messages" button click
document.querySelector('.messages-btn').addEventListener('click', function() {
    alert('Redirecting to Messages page...');
    window.location.href = 'messages.php'; // Change this URL to your actual Messages page URL
});

// Handle "Profile" button click
document.querySelector('.profile-btn').addEventListener('click', function() {
    alert('Redirecting to Profile page...');
    window.location.href = 'profile.php'; // Change this URL to your actual Profile page URL
});

// Example of dynamically loading company details (for now using static data)
document.addEventListener('DOMContentLoaded', function() {
    // Simulated company data (to be fetched from the backend)
    const companyData = {
        name: "BlueSky Airlines",
        bio: "Providing the best air travel experience.",
        address: "123 Sky Street, AirCity",
        location: "AirCity",
        logo: "path/to/logo.jpg", // Replace with actual logo path
        flightsCount: 10, // Example data, will be dynamically fetched
        accountDetails: {
            email: "info@bluesky.com",
            phone: "+123456789",
        }
    };

    // Populate the company dashboard with data
    document.querySelector('.company-name').textContent = companyData.name;
    document.querySelector('.company-bio').textContent = companyData.bio;
    document.querySelector('.company-address').textContent = companyData.address;
    document.querySelector('.company-location').textContent = companyData.location;
    document.querySelector('.company-flights').textContent = `Flights: ${companyData.flightsCount}`;
    document.querySelector('.company-email').textContent = `Email: ${companyData.accountDetails.email}`;
    document.querySelector('.company-phone').textContent = `Phone: ${companyData.accountDetails.phone}`;
    
    // Set the logo (if a logo path is provided)
    const logoElement = document.querySelector('.company-logo');
    if (companyData.logo) {
        logoElement.src = companyData.logo;
        logoElement.alt = companyData.name + " Logo";
    }

    // Handling actions when specific buttons are clicked
    document.querySelector('.view-flights-btn').addEventListener('click', function() {
        alert('Redirecting to Flights Management page...');
        window.location.href = 'manage-flights.php'; // Change this URL to your actual Flights Management page URL
    });

    document.querySelector('.edit-profile-btn').addEventListener('click', function() {
        alert('Redirecting to Profile Edit page...');
        window.location.href = 'edit-profile.html'; // Change this URL to your actual Profile Edit page URL
    });
});

// Function to handle the "Add Flight" button click
document.querySelector('.add-flight-btn').addEventListener('click', function() {
    alert('Redirecting to Add Flight page...');
    window.location.href = 'add-flight.html'; // Change this URL to your actual Add Flight page URL
});

// Function to handle the "Messages" button click
document.querySelector('.messages-btn').addEventListener('click', function() {
    alert('Redirecting to Messages page...');
    window.location.href = 'messages.html'; // Change this URL to your actual Messages page URL
});

// Function to handle the "Profile" button click
document.querySelector('.profile-btn').addEventListener('click', function() {
    alert('Redirecting to Profile page...');
    window.location.href = 'profile.html'; // Change this URL to your actual Profile page URL
});

// Wait for DOM content to load before adding event listener to the form
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.add-flight-form');
    
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting immediately

        // Get form field values
        const name = document.getElementById('name').value;
        const id = document.getElementById('id').value;
        const itinerary = document.getElementById('itinerary').value;
        const fees = document.getElementById('fees').value;
        const passengers = document.getElementById('passengers').value;
        const time = document.getElementById('time').value;

        // Basic validation to ensure all fields are filled
        if (!name || !id || !itinerary || !fees || !passengers || !time) {
            alert('Please fill in all fields');
            return;
        }

        // Send form data to backend or handle submission (AJAX example can be added here)
        alert('Flight added successfully!\n' +
              'Name: ' + name + '\n' +
              'ID: ' + id + '\n' +
              'Itinerary: ' + itinerary + '\n' +
              'Fees: ' + fees + '\n' +
              'Passengers: ' + passengers + '\n' +
              'Time: ' + time);

        // Reset the form after successful submission
        form.reset();
    });
});
/*flight details */
/// Sample data for demonstration purposes
const flightData = {
    101: {
        id: "101",
        name: "Flight 101",
        itinerary: "New York - Los Angeles",
        pendingPassengers: ["John Doe", "Jane Smith"],
        registeredPassengers: ["Emily White", "Michael Brown"],
    },
    102: {
        id: "102",
        name: "Flight 102",
        itinerary: "Chicago - Miami",
        pendingPassengers: ["Alice Johnson"],
        registeredPassengers: ["Bob Clark", "Diana Green"],
    },
};

// Helper function to extract query parameters from the URL
function getQueryParameter(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// Populate the flight details dynamically
document.addEventListener("DOMContentLoaded", () => {
    const flightId = getQueryParameter("id");

    if (flightId && flightData[flightId]) {
        const flight = flightData[flightId];

        // Update flight details on the page
        document.getElementById("flight-id").textContent = flight.id;
        document.getElementById("flight-name").textContent = flight.name;
        document.getElementById("flight-itinerary").textContent = flight.itinerary;

        // Populate passenger lists
        const pendingPassengersList = document.getElementById("pending-passengers");
        const registeredPassengersList = document.getElementById("registered-passengers");

        // Clear any existing passengers
        pendingPassengersList.innerHTML = '';
        registeredPassengersList.innerHTML = '';

        flight.pendingPassengers.forEach(passenger => {
            const li = document.createElement("li");
            li.textContent = `${passenger} (Pending)`;
            pendingPassengersList.appendChild(li);
        });

        flight.registeredPassengers.forEach(passenger => {
            const li = document.createElement("li");
            li.textContent = `${passenger} (Registered)`;
            registeredPassengersList.appendChild(li);
        });
    } else {
        alert("Invalid Flight ID!");
        window.history.back();
    }
});
});