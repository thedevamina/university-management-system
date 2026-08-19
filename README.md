<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&color=0:0f172a,100:1e3a8a&height=180&section=header&text=University%20Management%20System&fontSize=36&fontColor=93c5fd&fontAlignY=40&desc=A%20full-featured%20Laravel%20platform%20for%20Admins,%20Faculty%20%26%20Students&descAlignY=60&descSize=16&descColor=cbd5e1" width="100%"/>

<p>
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/TailwindCSS-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/Stripe-635BFF?style=for-the-badge&logo=stripe&logoColor=white" />
</p>

<i>Role-based campus management — Departments, Courses, Attendance, Exams, Fees & Subscriptions — built on a clean Repository–Service architecture.</i>

</div>

---

## 🧭 Overview

**UniSys** is a complete university management platform built in Laravel, supporting three roles — **Admin**, **Faculty**, and **Student** — each with their own dashboard and permissions. It goes beyond basic CRUD, layering in a proper **Repository → Service → Controller** architecture, **Stripe payments & recurring subscriptions**, and a full **webhook audit trail** for financial events.

---

## 🏗️ What I Built

| Module | Description |
|---|---|
| 🔐 **Auth & Roles** | Session-based login (Breeze) + custom role middleware for Admin / Faculty / Student |
| 🏛️ **Departments, Faculty & Students** | Full CRUD with auto-generated roll numbers and employee IDs |
| 📚 **Courses & Enrollments** | Many-to-many enrollment system, department-scoped course browsing |
| ✅ **Attendance** | Faculty mark attendance per course, per date, with roster view |
| 📝 **Exams & Results** | Marks entry with an **Eloquent Observer** that auto-calculates grades |
| 🗓️ **Timetable** | Conflict-free scheduling via a **custom validation rule** |
| 💳 **Payments (Stripe)** | One-time fee payments via Stripe Checkout, with Payment Intent tracking |
| 🔁 **Subscriptions** | Recurring monthly fee billing tied to a specific Fee record |
| 📡 **Webhook Audit Log** | Every Stripe event (success, failure, expiry) is logged and viewable by Admin |
| 🌐 **REST API** | Token-based API (Sanctum) for external/mobile access |

---

## 🧱 Architecture

```
Controller → Service (business logic) → Repository (queries) → Model → Database
```

Every module — from Departments to Payments — follows this layered pattern via **constructor-injected dependencies**, keeping controllers thin and logic testable/reusable.

```
app/
├── Http/Controllers/       → Request handling only
├── Services/                → Business rules (grade calc, roll-no generation, Stripe logic)
├── Repositories/            → All Eloquent queries
├── Models/                  → Relationships & casts
├── Observers/                → Auto grade calculation
└── Rules/                    → Custom validation (timetable clash checks)
```

---

## 🛠️ Tech Stack

**Backend:** Laravel 13 · PHP 8.3 · MySQL
**Frontend:** Blade · Tailwind CSS
**Payments:** Stripe Checkout + Webhooks (Sandbox)
**Auth:** Laravel Breeze (session) + Sanctum (API tokens)
**Tooling:** Vite · Composer · Git

---

## ✨ Highlights

- 🔁 Recurring subscriptions with full lifecycle tracking (`active`, `past_due`, `canceled`)
- 📡 Idempotent webhook processing — duplicate Stripe events are safely ignored
- 🧮 Auto-graded results via a Laravel **Observer**
- 🛡️ Role-scoped access control on every route
- 🧩 Reusable Blade components (sidebar, tables, status badges)

---

<div align="center">
<sub>Built as a hands-on Laravel deep-dive — from authentication to production-style payment infrastructure.</sub>
</div>