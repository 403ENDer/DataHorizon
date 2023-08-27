const nodemailer = require('nodemailer');

exports.handler = async (event, context) => {
    const { name, email, message } = JSON.parse(event.body);

    const transporter = nodemailer.createTransport({
        service: 'Gmail', // Use your email service here
        auth: {
            user: process.env.EMAIL_USER, // Use environment variables
            pass: process.env.EMAIL_PASSWORD // Use environment variables
        }
    });

    const mailOptions = {
        from: email,
        to: '71762133017@cit.edu.in', 
        subject: `New Contact Form Submission from ${name}`,
        text: message
    };

    try {
        await transporter.sendMail(mailOptions);
        return {
            statusCode: 200,
            body: JSON.stringify({ success: true, message: 'Email sent successfully!' })
        };
    } catch (error) {
        return {
            statusCode: 500,
            body: JSON.stringify({ success: false, message: 'Failed to send email.' })
        };
    }
};
