@extends('layouts.master')

@section('title', 'معرض الأعمال - نور الوجود')
@section('description', 'استعرض أحدث أعمالنا المتميزة في مجال التصميم الداخلي والديكور')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        /* ====== المتغيرات العامة ====== */
        :root {
            --primary-color: #404770;
            --primary-dark: #2c334f;
            --primary-light: #575b75;
            --accent-color: #e9a134;
            --text-dark: #333;
            --text-light: #777;
            --bg-light: #f8f9fa;
            --card-bg: #ffffff;
            --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 15px 35px rgba(0, 0, 0, 0.15);
            --shadow-primary: 0 10px 20px rgba(64, 71, 112, 0.15);
            --transition-fast: 0.3s ease;
            --transition-medium: 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            --transition-slow: 0.8s cubic-bezier(0.19, 1, 0.22, 1);
            --border-radius-sm: 8px;
            --border-radius-md: 15px;
            --border-radius-lg: 30px;
            --border-radius-xl: 50px;
        }

        /* ====== نمط عام للصفحة ====== */
        .portfolio-area {
            padding: 20px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .portfolio-area::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(64, 71, 112, 0.03) 0%, rgba(233, 161, 52, 0.03) 100%);
            top: -50px;
            left: -100px;
            z-index: -1;
            animation: float-slow 15s ease-in-out infinite alternate;
        }

        .portfolio-area::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(64, 71, 112, 0.03) 0%, rgba(233, 161, 52, 0.03) 100%);
            bottom: -200px;
            right: -200px;
            z-index: -1;
            animation: float-slow 20s ease-in-out infinite alternate-reverse;
        }

        @keyframes float-slow {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(50px, 50px) scale(1.1);
            }
        }

        /* ====== رأس الصفحة والـ Breadcrumbs ====== */
        .page-header {
            background: linear-gradient(135deg, rgba(64, 71, 112, 0.08) 0%, rgba(64, 71, 112, 0.03) 100%);
            padding: 4rem 1.5rem;
            border-radius: var(--border-radius-md);
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(64, 71, 112, 0.05);
            text-align: center;
        }

        .page-header::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23404770' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.8;
            z-index: -1;
        }

        .page-header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 1.2rem;
            position: relative;
            display: inline-block;
        }

        .page-header h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transform: translateX(-50%);
            border-radius: 50px;
        }

        .page-header p {
            color: var(--text-light);
            max-width: 700px;
            margin: 1.5rem auto;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .breadcrumb {
            display: flex;
            justify-content: center;
            padding: 0.8rem 1.5rem;
            margin-top: 2rem;
            list-style: none;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: var(--border-radius-xl);
            backdrop-filter: blur(5px);
            display: inline-flex;
            box-shadow: var(--shadow-sm);
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition-fast);
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a:hover {
            color: var(--accent-color);
            transform: translateY(-2px);
        }

        .breadcrumb-item a i {
            margin-left: 5px;
            font-size: 1.1rem;
        }

        .breadcrumb-item+.breadcrumb-item {
            padding-right: 0.7rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            display: inline-block;
            padding-left: 0.7rem;
            color: #adb5bd;
            content: "/";
        }

        .breadcrumb-item.active {
            color: var(--text-dark);
            font-weight: 600;
        }

        /* ====== أزرار التصفية ====== */
        .portfolio-filters-container {
            margin-bottom: 50px;
            text-align: center;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .portfolio-filters {
            display: inline-flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            background-color: var(--card-bg);
            padding: 10px 15px;
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            position: relative;
            z-index: 10;
            transition: var(--transition-medium);
            border: 1px solid rgba(64, 71, 112, 0.07);
        }

        .portfolio-filters::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: var(--border-radius-xl);
            padding: 2px;
            background: linear-gradient(135deg, rgba(64, 71, 112, 0.5), rgba(233, 161, 52, 0.5));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: var(--transition-medium);
        }

        .portfolio-filters:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-5px);
        }

        .portfolio-filters:hover::before {
            opacity: 1;
        }

        .portfolio-filter-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            margin: 5px;
            border: none;
            border-radius: var(--border-radius-xl);
            color: var(--text-dark);
            font-weight: 600;
            font-size: 15px;
            background-color: rgba(247, 249, 252, 0.8);
            cursor: pointer;
            overflow: hidden;
            position: relative;
            z-index: 1;
            transition: var(--transition-medium);
        }

        .portfolio-filter-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            z-index: -1;
            opacity: 0;
            transition: var(--transition-medium);
        }

        .portfolio-filter-btn i {
            margin-left: 10px;
            font-size: 18px;
            color: var(--primary-color);
            transition: all 0.4s ease;
        }

        .portfolio-filter-btn span {
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .portfolio-filter-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: var(--transition-fast);
            z-index: -1;
        }

        .portfolio-filter-btn:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-primary);
        }

        .portfolio-filter-btn:hover::before {
            opacity: 1;
        }

        .portfolio-filter-btn:hover::after {
            transform: translate(-50%, -50%) scale(3);
            opacity: 0;
        }

        .portfolio-filter-btn:hover i {
            color: white;
            transform: rotate(15deg) scale(1.2);
        }

        .portfolio-filter-btn:active {
            transform: translateY(-2px);
        }

        .portfolio-filter-btn.active {
            color: white;
            background-image: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: var(--shadow-primary);
        }

        .portfolio-filter-btn.active i {
            color: white;
        }

        /* تأثير نبض للزر النشط */
        @keyframes subtle-pulse {
            0% {
                box-shadow: 0 8px 25px rgba(64, 71, 112, 0.3);
            }

            50% {
                box-shadow: 0 12px 30px rgba(64, 71, 112, 0.5);
            }

            100% {
                box-shadow: 0 8px 25px rgba(64, 71, 112, 0.3);
            }
        }

        .portfolio-filter-btn.active {
            animation: subtle-pulse 3s infinite;
        }

        /* ====== بطاقات الأعمال ====== */
        .portfolio-grid {
            margin: 0 -15px;
            position: relative;
            transition: var(--transition-medium);
        }

        .portfolio-item {
            padding: 15px;
            transition: var(--transition-medium);
            will-change: transform, opacity;
        }

        .portfolio-card {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius-md);
            margin-bottom: 10px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-medium);
            background-color: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.03);
            height: 100%;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .portfolio-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: var(--border-radius-md);
            padding: 2px;
            background: linear-gradient(135deg, rgba(64, 71, 112, 0.5), rgba(233, 161, 52, 0.5));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: var(--transition-medium);
            pointer-events: none;
        }

        .portfolio-card:hover {
            transform: translateY(-15px) rotateX(5deg);
            box-shadow: var(--shadow-lg);
        }

        .portfolio-card:hover::after {
            opacity: 1;
        }

        .portfolio-image {
            position: relative;
            height: 280px;
            overflow: hidden;
        }

        .portfolio-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-slow);
        }

        .portfolio-card:hover .portfolio-image img {
            transform: scale(1.1);
        }

        .portfolio-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom,
                    rgba(64, 71, 112, 0.85) 0%,
                    rgba(40, 45, 75, 0.95) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition-medium);
            backdrop-filter: blur(3px);
        }

        .portfolio-card:hover .portfolio-overlay {
            opacity: 1;
        }

        .portfolio-overlay-content {
            text-align: center;
            color: white;
            padding: 20px;
            transform: translateY(25px);
            opacity: 0;
            transition: all 0.5s ease 0.1s;
            width: 90%;
        }

        .portfolio-card:hover .portfolio-overlay-content {
            transform: translateY(0);
            opacity: 1;
        }

        .portfolio-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            padding-bottom: 15px;
        }

        .portfolio-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 40px;
            height: 3px;
            background: var(--accent-color);
            transform: translateX(-50%);
            border-radius: 50px;
        }

        .portfolio-category {
            font-size: 15px;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
            position: relative;
            display: inline-block;
            padding: 0 15px;
        }

        .portfolio-category:before,
        .portfolio-category:after {
            content: '';
            position: absolute;
            top: 50%;
            width: 25px;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.5);
        }

        .portfolio-category:before {
            right: 100%;
        }

        .portfolio-category:after {
            left: 100%;
        }

        .portfolio-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: white;
            color: var(--primary-color);
            border-radius: var(--border-radius-xl);
            font-size: 15px;
            font-weight: 600;
            transition: var(--transition-medium);
            border: 2px solid white;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .portfolio-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            z-index: -1;
            opacity: 0;
            transition: var(--transition-medium);
        }

        .portfolio-button:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .portfolio-button:hover::before {
            opacity: 1;
        }

        .portfolio-button i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .portfolio-button:hover i {
            transform: translateX(-5px);
        }

        .portfolio-info {
            padding: 25px;
            background-color: var(--card-bg);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;
        }

        .portfolio-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 0;
            background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
            transition: var(--transition-medium);
            z-index: -1;
        }

        .portfolio-card:hover .portfolio-info::before {
            height: 100%;
        }

        .portfolio-info-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-dark);
            transition: var(--transition-fast);
        }

        .portfolio-card:hover .portfolio-info-title {
            color: var(--primary-color);
            transform: translateX(10px);
        }

        .portfolio-info-category {
            font-size: 14px;
            color: var(--text-light);
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: var(--transition-fast);
        }

        .portfolio-card:hover .portfolio-info-category {
            transform: translateX(10px);
        }

        .portfolio-info-category:before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            margin-left: 8px;
            border-radius: 50%;
        }

        /* ====== مؤشر التحميل للمحتوى ====== */
        .portfolio-loading {
            text-align: center;
            padding: 40px;
            display: none;
        }

        .portfolio-loading .spinner {
            width: 50px;
            height: 50px;
            margin: 0 auto;
            position: relative;
        }

        .portfolio-loading .spinner:before,
        .portfolio-loading .spinner:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: var(--primary-color);
            opacity: 0.6;
            animation: sk-bounce 2s infinite ease-in-out;
        }

        .portfolio-loading .spinner:after {
            animation-delay: -1s;
        }

        @keyframes sk-bounce {

            0%,
            100% {
                transform: scale(0);
            }

            50% {
                transform: scale(1);
            }
        }

        .portfolio-loading p {
            margin-top: 20px;
            color: var(--text-light);
            font-weight: 500;
        }

        /* ====== خيارات عرض المعرض ====== */
        .view-options {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 10px;
        }

        .view-option-btn {
            background-color: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: var(--border-radius-sm);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-fast);
            color: var(--text-light);
        }

        .view-option-btn:hover,
        .view-option-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: var(--shadow-sm);
        }

        .view-option-btn i {
            font-size: 1.1rem;
        }

        /* ====== الحالة الفارغة ====== */
        .empty-portfolio {
            text-align: center;
            padding: 80px 20px;
            background-color: rgba(247, 249, 252, 0.8);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-sm);
            border: 1px dashed rgba(0, 0, 0, 0.1);
        }

        .empty-portfolio i {
            font-size: 4rem;
            color: var(--text-light);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-portfolio h4 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .empty-portfolio p {
            color: var(--text-light);
            max-width: 500px;
            margin: 0 auto;
        }

        /* ====== قسم CTA ====== */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 80px 0;
            margin-top: 50px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            top: -150px;
            right: -150px;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            bottom: -100px;
            left: -100px;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .cta-section h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            width: 80px;
            height: 4px;
            background: var(--accent-color);
            transform: translateX(-50%);
            border-radius: 50px;
        }

        .cta-section p {
            color: rgba(255, 255, 255, 0.8);
            max-width: 700px;
            margin: 1.5rem auto;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 35px;
            background-color: var(--accent-color);
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius-xl);
            margin-top: 20px;
            text-decoration: none;
            transition: var(--transition-medium);
            box-shadow: 0 10px 25px rgba(233, 161, 52, 0.3);
            border: 2px solid var(--accent-color);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: transparent;
            z-index: -1;
            transition: var(--transition-medium);
        }

        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(233, 161, 52, 0.4);
            color: var(--accent-color);
        }

        .cta-button:hover::before {
            background-color: white;
        }

        /* ====== تحسينات للأجهزة المحمولة ====== */
        @media (max-width: 1199.98px) {
            .portfolio-title {
                font-size: 20px;
            }

            .portfolio-button {
                padding: 10px 25px;
                font-size: 14px;
            }
        }

        @media (max-width: 991.98px) {
            .page-header {
                padding: 3rem 1rem;
            }

            .page-header h1 {
                font-size: 2.4rem;
            }

            .portfolio-filters {
                padding: 10px;
            }

            .portfolio-filter-btn {
                padding: 10px 20px;
                font-size: 14px;
                margin: 3px;
            }

            .portfolio-filter-btn i {
                font-size: 16px;
            }

            .portfolio-image {
                height: 250px;
            }

            .cta-section h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 767.98px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .page-header p {
                font-size: 1rem;
            }

            .breadcrumb {
                padding: 0.6rem 1.2rem;
                margin-top: 1.5rem;
            }

            .portfolio-filters-container {
                margin-bottom: 30px;
            }

            .portfolio-filter-btn {
                padding: 8px 15px;
                font-size: 13px;
            }

            .portfolio-filter-btn i {
                margin-left: 5px;
            }

            .portfolio-image {
                height: 220px;
            }

            .portfolio-title {
                font-size: 18px;
            }

            .portfolio-category {
                font-size: 14px;
                margin-bottom: 15px;
            }

            .portfolio-button {
                padding: 8px 20px;
                font-size: 13px;
            }

            .cta-section {
                padding: 60px 0;
            }

            .cta-section h2 {
                font-size: 1.8rem;
            }

            .cta-section p {
                font-size: 1rem;
            }

            .cta-button {
                padding: 12px 30px;
            }
        }

        @media (max-width: 575.98px) {
            .page-header h1 {
                font-size: 1.8rem;
            }

            .portfolio-filters {
                padding: 8px;
            }

            .portfolio-filter-btn {
                padding: 7px 12px;
                font-size: 12px;
                margin: 2px;
            }

            .portfolio-filter-btn i {
                font-size: 14px;
                margin-left: 3px;
            }

            .portfolio-title {
                font-size: 16px;
                margin-bottom: 8px;
            }

            .portfolio-button {
                padding: 8px 18px;
                font-size: 12px;
            }

            .portfolio-info {
                padding: 20px;
            }

            .portfolio-info-title {
                font-size: 16px;
            }

            .portfolio-info-category {
                font-size: 12px;
            }

            .cta-section h2 {
                font-size: 1.6rem;
            }
        }

        /* ====== تأثيرات متقدمة ====== */
        @media (prefers-reduced-motion: no-preference) {
            .portfolio-item {
                transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1), opacity 0.6s ease;
            }

            .portfolio-item.portfolio-animate-in {
                animation: portfolio-item-in 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
            }

            @keyframes portfolio-item-in {
                0% {
                    opacity: 0;
                    transform: translateY(30px) scale(0.95);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
        }
    </style>
@endsection

@section('content')
    <main id="main">
        <div class="container py-5 mt-5">
            <!-- رأس الصفحة مع breadcrumbs -->
            <div class="page-header">
                <h1>معرض أعمالنا</h1>
                <p>نقدم لكم مجموعة متميزة من أحدث وأفضل أعمالنا في مجالات التصميم الداخلي والديكور، نلتزم بأعلى معايير
                    الجودة والإبداع في التصميم والتنفيذ</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                <i class="bi bi-house-door"></i> الرئيسية
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">معرض الأعمال</li>
                    </ol>
                </nav>
            </div>

            <!-- ======= معرض الأعمال Section ======= -->
            <section class="portfolio-area">
                <div class="container-fluid" data-aos="fade-up">
                    @if ($portfolios && $portfolios->count() > 0)
                        <!-- مرشحات التصنيفات -->
                        @php
                            $categories = $portfolios->pluck('category')->filter()->unique();
                        @endphp

                        @if ($categories->count() > 0)
                            <div class="portfolio-filters-container" data-aos="fade-up" data-aos-delay="100">
                                <div class="portfolio-filters">
                                    <button class="portfolio-filter-btn active" data-filter="*" title="جميع الأعمال">
                                        <i class="bi bi-grid-3x3-gap"></i>
                                        <span>جميع الأعمال</span>
                                    </button>
                                    @foreach ($categories as $category)
                                        <button class="portfolio-filter-btn" data-filter=".{{ Str::slug($category) }}"
                                            title="{{ $category }}">
                                            <i class="bi bi-bookmark"></i>
                                            <span>{{ $category }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- خيارات عرض المعرض -->
                        <div class="view-options" data-aos="fade-up" data-aos-delay="150">
                            <button class="view-option-btn active" data-view="grid" title="عرض شبكي">
                                <i class="bi bi-grid"></i>
                            </button>
                            <button class="view-option-btn" data-view="list" title="عرض قائمة">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>

                        <!-- مؤشر التحميل -->
                        <div class="portfolio-loading">
                            <div class="spinner"></div>
                            <p class="mt-3">جاري تحميل الأعمال...</p>
                        </div>

                        <!-- معرض الأعمال -->
                        <div class="row portfolio-grid" id="portfolio-container">
                            @foreach ($portfolios as $portfolio)
                                <div class="col-lg-4 col-md-6 portfolio-item {{ $portfolio->category ? Str::slug($portfolio->category) : '' }}"
                                    data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 + 200 }}">
                                    <div class="portfolio-card">
                                        <a href="{{ route('portfolio.show', $portfolio->id) }}#portfolio-gallery"
                                            class="portfolio-card-link">
                                            <div class="portfolio-image">
                                                <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}"
                                                    loading="lazy">
                                                <div class="portfolio-overlay">
                                                    <div class="portfolio-overlay-content">
                                                        <h3 class="portfolio-title">{{ $portfolio->title }}</h3>
                                                        @if ($portfolio->category)
                                                            <div class="portfolio-category">{{ $portfolio->category }}
                                                            </div>
                                                        @endif
                                                        <span class="portfolio-button">
                                                            <i class="bi bi-images"></i> عرض التفاصيل
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-info">
                                                <h3 class="portfolio-info-title">{{ $portfolio->title }}</h3>
                                                @if ($portfolio->category)
                                                    <div class="portfolio-info-category">{{ $portfolio->category }}</div>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-portfolio" data-aos="fade-up" data-aos-delay="100">
                            <i class="bi bi-images"></i>
                            <h4>لا توجد أعمال في المعرض حالياً</h4>
                            <p>يرجى العودة لاحقاً عندما يتم إضافة أعمال جديدة إلى معرض الأعمال الخاص بنا.</p>
                        </div>
                    @endif
                </div>
            </section><!-- نهاية قسم معرض الأعمال -->
        </div>

        <!-- ======= CTA Section ======= -->
        <div class="cta-section">
            <div class="container">
                <h2 class="text-white">هل لديك مشروع تبحث عن تنفيذه باحترافية؟</h2>
                <p>تواصل معنا الآن للحصول على استشارة مجانية ومعرفة كيف يمكننا مساعدتك في تنفيذ مشروعك بأعلى مستويات الجودة
                    والإبداع والدقة.</p>
                <a href="{{ route('home') }}#contact" class="cta-button">تواصل معنا الآن</a>
            </div>
        </div><!-- End CTA Section -->
    </main><!-- End #main -->
@endsection

@section('script')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            "use strict";

            // تهيئة AOS (Animate On Scroll)
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false,
                offset: 100
            });

            // عرض مؤشر التحميل
            const loadingIndicator = document.querySelector('.portfolio-loading');
            if (loadingIndicator) {
                loadingIndicator.style.display = 'block';
            }

            // متغيرات عامة
            let iso;
            let currentView = 'grid';
            const portfolioContainer = document.getElementById('portfolio-container');
            const portfolioItems = document.querySelectorAll('.portfolio-item');

            // عند اكتمال تحميل الصفحة
            window.addEventListener('load', function() {
                // إخفاء مؤشر التحميل
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }

                // التأكد من وجود حاوية المعرض
                if (!portfolioContainer) return;

                // تطبيق تأثير الظهور على العناصر
                portfolioItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.classList.add('portfolio-animate-in');
                    }, index * 100);
                });

                // التأكد من تحميل جميع الصور قبل تهيئة Isotope
                imagesLoaded(portfolioContainer, function() {
                    // تهيئة Isotope
                    iso = new Isotope(portfolioContainer, {
                        itemSelector: '.portfolio-item',
                        layoutMode: 'fitRows',
                        transitionDuration: '0.6s',
                        stagger: 50,
                        fitRows: {
                            gutter: 0
                        }
                    });

                    // تهيئة أزرار التصفية
                    const portfolioFilters = document.querySelectorAll('.portfolio-filter-btn');

                    portfolioFilters.forEach(function(filter) {
                        filter.addEventListener('click', function(e) {
                            e.preventDefault();

                            // إزالة الكلاس النشط من جميع الأزرار
                            portfolioFilters.forEach(function(btn) {
                                btn.classList.remove('active');
                            });

                            // إضافة الكلاس النشط للزر المنقور
                            this.classList.add('active');

                            // الحصول على قيمة الفلتر
                            const filterValue = this.getAttribute('data-filter');
                            console.log('الفلتر المحدد:', filterValue);

                            // عرض مؤشر التحميل مؤقتًا أثناء الفلترة
                            if (loadingIndicator) {
                                loadingIndicator.style.display = 'block';
                            }

                            // تطبيق تأثير حركة للعناصر
                            const items = document.querySelectorAll(
                                '.portfolio-item');
                            items.forEach(item => {
                                item.style.opacity = '0.5';
                                item.style.transform = 'scale(0.95)';
                            });

                            // تطبيق الفلتر بعد تأخير قصير للسماح بتأثير الانتقال
                            setTimeout(function() {
                                iso.arrange({
                                    filter: filterValue
                                });

                                // بعد الفلترة، أظهر العناصر المرئية بتأثير
                                setTimeout(function() {
                                    const visibleItems = document
                                        .querySelectorAll(
                                            filterValue !== '*' ?
                                            filterValue :
                                            '.portfolio-item');

                                    visibleItems.forEach((item,
                                        index) => {
                                        setTimeout(() => {
                                                item.style
                                                    .opacity =
                                                    '1';
                                                item.style
                                                    .transform =
                                                    'scale(1)';
                                            }, index *
                                            50);
                                    });

                                    // إخفاء مؤشر التحميل
                                    if (loadingIndicator) {
                                        loadingIndicator.style
                                            .display = 'none';
                                    }
                                }, 200);
                            }, 300);

                            // تأثير تموج عند النقر
                            createRippleEffect(this, e);
                        });
                    });

                    // تهيئة أزرار طريقة العرض
                    const viewButtons = document.querySelectorAll('.view-option-btn');
                    viewButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            // التحقق من الزر النشط حاليًا
                            if (this.classList.contains('active')) return;

                            // إزالة الكلاس النشط من جميع الأزرار
                            viewButtons.forEach(btn => btn.classList.remove(
                                'active'));

                            // إضافة الكلاس النشط للزر المنقور
                            this.classList.add('active');

                            // الحصول على نوع العرض
                            const viewType = this.getAttribute('data-view');

                            // تطبيق نوع العرض
                            changeView(viewType);

                            // تأثير تموج
                            createRippleEffect(this, event);
                        });
                    });

                    // تأثير الحركة عند مرور الماوس على البطاقات
                    initializeCardHoverEffects();

                    // إضافة تأثير parallax للبطاقات
                    initializeParallaxEffect();
                });
            });

            // وظيفة تغيير طريقة العرض
            function changeView(viewType) {
                if (viewType === currentView) return;

                currentView = viewType;

                // عرض مؤشر التحميل
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'block';
                }

                // تطبيق التغييرات حسب نوع العرض
                if (viewType === 'list') {
                    // تحويل العرض إلى قائمة
                    portfolioItems.forEach(item => {
                        item.classList.remove('col-lg-4', 'col-md-6');
                        item.classList.add('col-12', 'list-view');
                    });
                } else {
                    // تحويل العرض إلى شبكة
                    portfolioItems.forEach(item => {
                        item.classList.remove('col-12', 'list-view');
                        item.classList.add('col-lg-4', 'col-md-6');
                    });
                }

                // إعادة تهيئة Isotope بعد تغيير العرض
                setTimeout(() => {
                    if (iso) {
                        iso.reloadItems();
                        iso.arrange();
                    }

                    // إخفاء مؤشر التحميل
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none';
                    }
                }, 300);
            }

            // وظيفة تهيئة تأثيرات الحركة عند مرور الماوس
            function initializeCardHoverEffects() {
                const portfolioCards = document.querySelectorAll('.portfolio-card');
                portfolioCards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        const nearbyCards = this.closest('.portfolio-item').parentNode
                            .querySelectorAll('.portfolio-item:not(:hover) .portfolio-card');
                        nearbyCards.forEach(nearbyCard => {
                            nearbyCard.style.transform = 'scale(0.98)';
                            nearbyCard.style.opacity = '0.8';
                        });
                    });

                    card.addEventListener('mouseleave', function() {
                        const allCards = document.querySelectorAll('.portfolio-card');
                        allCards.forEach(c => {
                            c.style.transform = '';
                            c.style.opacity = '';
                        });
                    });
                });
            }

            // وظيفة إنشاء تأثير التموج (Ripple)
            function createRippleEffect(element, event) {
                const rect = element.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;

                const ripple = document.createElement('span');
                ripple.classList.add('ripple-effect');
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                element.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            }

            // وظيفة إضافة تأثير parallax للبطاقات
            function initializeParallaxEffect() {
                document.querySelectorAll('.portfolio-card').forEach(card => {
                    card.addEventListener('mousemove', function(e) {
                        const rect = this.getBoundingClientRect();
                        const x = e.clientX - rect.left; // موقع الماوس بالنسبة للبطاقة X
                        const y = e.clientY - rect.top; // موقع الماوس بالنسبة للبطاقة Y

                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;

                        // حساب مقدار الدوران (بحد أقصى 5 درجات)
                        const rotateX = (centerY - y) / 30;
                        const rotateY = (x - centerX) / 30;

                        // تطبيق التأثير بسلاسة
                        this.style.transform =
                            `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;

                        // تأثير ظل الإسقاط
                        const shadowX = (x - centerX) / 15;
                        const shadowY = (y - centerY) / 15;
                        this.style.boxShadow = `${shadowX}px ${shadowY}px 30px rgba(0, 0, 0, 0.1)`;
                    });

                    card.addEventListener('mouseleave', function() {
                        // إعادة البطاقة لحالتها الأصلية
                        this.style.transform = '';
                        this.style.boxShadow = '';
                    });
                });
            }
        });
    </script>
@endsection
