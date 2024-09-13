<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Hotel Hall & Meeting Room Booking Application

**Developed using Laravel (PHP), HTML, CSS**

## Project Overview
This web application is designed to manage the booking of hotel halls and meeting rooms. It includes features for receptionists to verify payments, manage check-ins and check-outs, and for guests to make and cancel bookings, as well as upload payment proofs.

## Features

### Receptionist Features

- **Payment Verification**:
  - If payment is made **up to 5 hours** after booking: Payment is valid, booking status becomes **valid**, and meeting room/hall status becomes **unavailable**.
  - If payment is made **more than 5 hours** after booking: Payment is invalid, booking status becomes **invalid**, and meeting room/hall status remains **available**.
  
- **Check-in**:
  - Verify that the check-in date matches the booking.
  - Successful check-in marks the guest's status as checked in.
  
- **Check-out**:
  - Check for any damage to items or facilities.
  - Successful check-out makes the meeting room/hall status **available** again.

### Guest Features

- **Booking Cancellation**:
  - If cancellation is made **at least 2 days** before the event date: The cancellation is allowed, and the meeting room/hall status becomes **available** again.
  - If cancellation is made **less than 2 days** before the event date: Cancellation is not allowed, the room/hall status remains **unavailable**, and any refund requests are handled via reports.

- **Payment**:
  - Guests can upload an image as **proof of payment** for their booking.

## Technology Stack
- **Laravel** (Backend)
- **PHP** (Backend)
- **HTML/CSS** (Frontend)

## Usage
- Receptionists can manage booking verifications, check-in and check-out processes, and ensure room availability is updated based on guest actions.
- Guests can manage their bookings, upload payment proofs, and request cancellations if eligible.

---

Let me know if you'd like to add more information or adjustments!
