$(document).ready(function() {
    $('#registrationForm').on('submit', function(e) {
        e.preventDefault();
        
        // Collect form data
        const formData = {
            fullName: $('#fullName').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            dob: $('#dob').val(),
            gender: $('input[name="gender"]:checked').val(),
            address: $('#address').val(),
            course: $('#course').val()
        };

        // Send data to PHP backend
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displayResult(response.data);
                    $('#registrationForm')[0].reset();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while processing your request.');
            }
        });
    });

    function displayResult(data) {
        const resultHTML = `
            <div class="success-icon">✓</div>
            <h2>Registration Successful!</h2>
            <div class="result-item">
                <span class="result-label">Full Name:</span>
                <span class="result-value">${data.fullName}</span>
            </div>
            <div class="result-item">
                <span class="result-label">Email:</span>
                <span class="result-value">${data.email}</span>
            </div>
            <div class="result-item">
                <span class="result-label">Phone:</span>
                <span class="result-value">${data.phone}</span>
            </div>
            <div class="result-item">
                <span class="result-label">Date of Birth:</span>
                <span class="result-value">${data.dob}</span>
            </div>
            <div class="result-item">
                <span class="result-label">Gender:</span>
                <span class="result-value">${data.gender}</span>
            </div>
            <div class="result-item">
                <span class="result-label">Address:</span>
                <span class="result-value">${data.address}</span>
            </div>
            <div class="result-item">
                <span class="result-label">Course:</span>
                <span class="result-value">${data.course}</span>
            </div>
            <div class="result-item">
                <span class="result-label">Submission Time:</span>
                <span class="result-value">${data.timestamp}</span>
            </div>
        `;
        
        $('#result').html(resultHTML).removeClass('hidden');
        
        // Smooth scroll to result
        $('html, body').animate({
            scrollTop: $('#result').offset().top - 20
        }, 500);
    }
});
