<p align="center">
  <img src="./.github/hero.svg" alt="University Management System — Laravel role-based campus platform" width="100%" />
</p>

<p align="center">
  A full-featured campus platform for <strong>Admins</strong>, <strong>Faculty</strong>, and <strong>Students</strong> — built on Laravel with a clean Repository–Service architecture and Stripe-powered billing.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-0f1b30?style=for-the-badge&logo=php&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/Laravel-0f1b30?style=for-the-badge&logo=laravel&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/MySQL-0f1b30?style=for-the-badge&logo=mysql&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/TailwindCSS-0f1b30?style=for-the-badge&logo=tailwindcss&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/Stripe-0f1b30?style=for-the-badge&logo=stripe&logoColor=38bdf8" />
</p>

<p align="center">
  <a href="https://github.com/thedevamina/university-management-system"><img src="https://img.shields.io/badge/Repo-view_source-0f1b30?style=flat-square&logoColor=38bdf8" /></a>
  <a href="https://github.com/thedevamina"><img src="https://img.shields.io/badge/@thedevamina-0f1b30?style=flat-square&logo=github&logoColor=38bdf8" /></a>
</p>

<br/>

## What I Built

<table>
  <tr>
    <td width="25%" valign="top">
      <h3>🔐 Access Control</h3>
      <p>Session-based auth with custom role middleware for Admin, Faculty, and Student.</p>
    </td>
    <td width="25%" valign="top">
      <h3>📚 Academics</h3>
      <p>Departments, courses, enrollments, attendance, and observer-driven grade calculation.</p>
    </td>
    <td width="25%" valign="top">
      <h3>💳 Billing</h3>
      <p>One-time Stripe payments and recurring subscriptions tied to fee records.</p>
    </td>
    <td width="25%" valign="top">
      <h3>📡 Reliability</h3>
      <p>Idempotent webhook processing with a full, admin-visible audit trail.</p>
    </td>
  </tr>
</table>

<br/>

## Modules

<table>
  <tr>
    <td width="50%" valign="top">
      <h3>🏛️ Core Platform</h3>
      <p>Departments, Faculty, Students, Courses, and Enrollments with department-scoped auto-generated roll numbers and employee IDs.</p>
      <p>
        <img src="https://img.shields.io/badge/Eloquent_ORM-0f1b30?style=flat-square&logoColor=38bdf8" />
        <img src="https://img.shields.io/badge/Repository_Pattern-0f1b30?style=flat-square&logoColor=38bdf8" />
      </p>
    </td>
    <td width="50%" valign="top">
      <h3>✅ Attendance & Exams</h3>
      <p>Per-course attendance rosters, exam creation, and marks entry with an Eloquent Observer that auto-calculates grades.</p>
      <p>
        <img src="https://img.shields.io/badge/Observers-0f1b30?style=flat-square&logoColor=38bdf8" />
        <img src="https://img.shields.io/badge/Custom_Validation-0f1b30?style=flat-square&logoColor=38bdf8" />
      </p>
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <h3>💳 Payments & Subscriptions</h3>
      <p>Stripe Checkout for one-time fees, plus recurring monthly billing with full lifecycle tracking (active, past due, canceled).</p>
      <p>
        <img src="https://img.shields.io/badge/Stripe_Checkout-0f1b30?style=flat-square&logo=stripe&logoColor=38bdf8" />
        <img src="https://img.shields.io/badge/Webhooks-0f1b30?style=flat-square&logoColor=38bdf8" />
      </p>
    </td>
    <td width="50%" valign="top">
      <h3>🗓️ Timetable & API</h3>
      <p>Conflict-free scheduling via a custom validation rule, plus a token-based REST API for external/mobile access.</p>
      <p>
        <img src="https://img.shields.io/badge/Laravel_Sanctum-0f1b30?style=flat-square&logoColor=38bdf8" />
        <img src="https://img.shields.io/badge/REST_API-0f1b30?style=flat-square&logoColor=38bdf8" />
      </p>
    </td>
  </tr>
</table>

<br/>

## Architecture

<p align="center">
  <img src="https://img.shields.io/badge/Controller-0f1b30?style=flat-square&logoColor=38bdf8" /> →
  <img src="https://img.shields.io/badge/Service-132542?style=flat-square&logoColor=38bdf8" /> →
  <img src="https://img.shields.io/badge/Repository-0f1b30?style=flat-square&logoColor=38bdf8" /> →
  <img src="https://img.shields.io/badge/Model-132542?style=flat-square&logoColor=38bdf8" /> →
  <img src="https://img.shields.io/badge/Database-0f1b30?style=flat-square&logoColor=38bdf8" />
</p>

Every module — from Departments to Payments — follows this layered pattern via constructor-injected dependencies, keeping controllers thin and business logic reusable and testable.

```
app/
├── Http/Controllers/   → Request handling only
├── Services/            → Business rules (grade calc, roll-no generation, Stripe logic)
├── Repositories/        → All Eloquent queries
├── Models/              → Relationships & casts
├── Observers/           → Auto grade calculation
└── Rules/               → Custom validation (timetable clash checks)
```

<br/>

## Tech Stack

<p>
  <img src="https://img.shields.io/badge/PHP-0f1b30?style=flat-square&logo=php&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/Laravel-0f1b30?style=flat-square&logo=laravel&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/MySQL-0f1b30?style=flat-square&logo=mysql&logoColor=38bdf8" />
  <br/>
  <img src="https://img.shields.io/badge/Blade-0f1b30?style=flat-square&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/TailwindCSS-0f1b30?style=flat-square&logo=tailwindcss&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/Vite-0f1b30?style=flat-square&logo=vite&logoColor=38bdf8" />
  <br/>
  <img src="https://img.shields.io/badge/Stripe-0f1b30?style=flat-square&logo=stripe&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/Laravel_Sanctum-0f1b30?style=flat-square&logoColor=38bdf8" />
  <img src="https://img.shields.io/badge/Git-0f1b30?style=flat-square&logo=git&logoColor=38bdf8" />
</p>

<br/>

## Highlights

- 🔁 Recurring subscriptions with full lifecycle tracking, tied to a specific fee record
- 📡 Idempotent webhook processing — duplicate Stripe events are safely ignored
- 🧮 Auto-graded results via a Laravel Observer, no manual calculation
- 🛡️ Role-scoped access control enforced on every route
- 🧩 Reusable Blade components — sidebar, tables, status badges

<br/>

---

<p align="center">
  <em>Built as a hands-on Laravel deep-dive — from authentication to production-style payment infrastructure.</em>
</p>

<p align="center">
  <a href="https://github.com/thedevamina"><img src="https://img.shields.io/badge/@thedevamina-0f1b30?style=for-the-badge&logo=github&logoColor=38bdf8" /></a>
</p>