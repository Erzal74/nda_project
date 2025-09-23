@extends('layouts.app')

@section('title', 'Detail Proyek NDA')

@push('styles')
    <style>
        /* Use same CSS variables as other pages */
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #4338ca;
            --primary-bg: rgba(79, 70, 229, 0.08);
            --secondary: #6b7280;
            --secondary-light: #9ca3af;
            --secondary-dark: #4b5563;
            --secondary-bg: rgba(107, 114, 128, 0.08);
            --success: #10b981;
            --success-light: #34d399;
            --success-dark: #059669;
            --success-bg: rgba(16, 185, 129, 0.08);
            --warning: #f59e0b;
            --warning-light: #fbbf24;
            --warning-dark: #d97706;
            --warning-bg: rgba(245, 158, 11, 0.08);
            --danger: #ef4444;
            --danger-light: #f87171;
            --danger-dark: #dc2626;
            --danger-bg: rgba(239, 68, 68, 0.08);
            --info: #0ea5e9;
            --info-light: #38bdf8;
            --info-dark: #0284c7;
            --info-bg: rgba(14, 165, 233, 0.08);
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 8px;
            --radius-sm: 6px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-2xl: 20px;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
            min-height: 100vh;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
            background: white;
            padding: 2rem;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .header-text {
            flex: 1;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.025em;
        }

        .page-subtitle {
            font-size: 1rem;
            color: var(--gray-600);
            margin: 0;
            line-height: 1.5;
        }

        .header-action {
            display: flex;
            align-items: center;
        }

        /* Project Hero Banner */
        .project-hero {
            background: linear-gradient(135deg, var(--primary-bg) 0%, var(--info-bg) 100%);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .project-hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, var(--primary-bg) 0%, transparent 70%);
            opacity: 0.5;
        }

        .hero-content {
            display: flex;
            align-items: flex-start;
            gap: 2rem;
            position: relative;
            z-index: 1;
        }

        .project-status-icon {
            width: 5rem;
            height: 5rem;
            background: white;
            color: var(--primary);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
            box-shadow: var(--shadow-md);
        }

        .hero-details {
            flex: 1;
            min-width: 0;
        }

        .project-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 1rem 0;
            line-height: 1.2;
            word-break: break-word;
        }

        .project-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: var(--gray-700);
            font-weight: 500;
        }

        .hero-actions {
            display: flex;
            align-items: flex-start;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .quick-stats-grid {
            display: flex;
            align-items: stretch;
            gap: 1.5rem;
        }

        .quick-stat {
            background: white;
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            min-width: 120px;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 120px;
        }

        .quick-stat:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .quick-stat .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .quick-stat .stat-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            font-weight: 500;
            white-space: nowrap;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
        }

        /* Main Content */
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Detail Sections */
        .detail-section {
            background: white;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .section-header {
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            padding: 2rem;
            border-bottom: 1px solid var(--gray-200);
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        }

        .section-icon {
            width: 3rem;
            height: 3rem;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .section-icon-primary {
            background: var(--primary-bg);
            color: var(--primary);
        }

        .section-icon-info {
            background: var(--info-bg);
            color: var(--info);
        }

        .section-content {
            flex: 1;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 0.5rem 0;
        }

        .section-description {
            font-size: 1rem;
            color: var(--gray-600);
            margin: 0;
            line-height: 1.5;
        }

        .section-body {
            padding: 2rem;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-card {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            transition: var(--transition);
        }

        .info-card:hover {
            background: white;
            border-color: var(--gray-300);
            box-shadow: var(--shadow-sm);
            transform: translateY(-1px);
        }

        .info-card.col-span-2 {
            grid-column: 1 / -1;
        }

        .info-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .info-icon {
            color: var(--primary);
            font-size: 1.125rem;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        .info-value {
            font-size: 1rem;
            color: var(--gray-900);
            font-weight: 500;
            line-height: 1.5;
            word-break: break-word;
        }

        .text-muted {
            color: var(--gray-500) !important;
            font-style: italic;
        }

        /* Members Grid */
        .members-grid {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .member-card {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: var(--transition);
        }

        .member-card:hover {
            background: white;
            border-color: var(--gray-300);
            box-shadow: var(--shadow-sm);
        }

        .member-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, white 0%, var(--gray-50) 100%);
            border-bottom: 1px solid var(--gray-200);
        }

        .member-avatar {
            width: 3rem;
            height: 3rem;
            background: var(--primary-bg);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
            box-shadow: var(--shadow-xs);
        }

        .member-info {
            flex: 1;
            min-width: 0;
        }

        .member-name {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 0.25rem 0;
            word-break: break-word;
        }

        .member-role {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin: 0;
        }

        .member-status {
            flex-shrink: 0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-success {
            background: var(--success-bg);
            color: var(--success-dark);
        }

        .status-warning {
            background: var(--warning-bg);
            color: var(--warning-dark);
        }

        /* Member Documents */
        .member-documents {
            padding: 1.5rem;
        }

        .documents-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .document-item {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: var(--transition);
        }

        .document-item:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        .document-preview {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            min-width: 0;
        }

        .document-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--danger-bg);
            color: var(--danger);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .document-details {
            flex: 1;
            min-width: 0;
        }

        .document-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
            word-break: break-all;
        }

        .document-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .upload-date {
            font-size: 0.75rem;
            color: var(--gray-500);
            display: flex;
            align-items: center;
        }

        .document-actions {
            display: flex;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .btn-action {
            width: 2rem;
            height: 2rem;
            border: none;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .btn-view {
            background: var(--primary-bg);
            color: var(--primary);
        }

        .btn-view:hover {
            background: var(--primary);
            color: white;
        }

        .btn-download {
            background: var(--success-bg);
            color: var(--success);
        }

        .btn-download:hover {
            background: var(--success);
            color: white;
        }

        /* Empty States */
        .empty-documents {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 2rem;
            background: var(--gray-50);
            border: 2px dashed var(--gray-300);
            border-radius: var(--radius);
            text-align: center;
        }

        .empty-icon {
            font-size: 2rem;
            color: var(--gray-400);
            flex-shrink: 0;
        }

        .empty-text {
            flex: 1;
        }

        .empty-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.25rem;
        }

        .empty-subtitle {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 3rem 2rem;
        }

        .empty-state .empty-icon {
            font-size: 4rem;
            color: var(--gray-300);
            margin-bottom: 1rem;
        }

        .empty-state .empty-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .empty-state .empty-subtitle {
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        /* Sidebar */
        .sidebar-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .sidebar-card {
            background: white;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        }

        .card-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .card-icon-primary {
            background: var(--primary-bg);
            color: var(--primary);
        }

        .card-icon-success {
            background: var(--success-bg);
            color: var(--success);
        }

        .card-icon-info {
            background: var(--info-bg);
            color: var(--info);
        }

        .card-title {
            flex: 1;
        }

        .card-title h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 0.25rem 0;
        }

        .card-title p {
            font-size: 0.75rem;
            color: var(--gray-600);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Status Display */
        .status-display {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            text-align: center;
        }

        .status-display.status-success {
            background: var(--success-bg);
            border: 1px solid var(--success);
        }

        .status-display.status-warning {
            background: var(--warning-bg);
            border: 1px solid var(--warning);
        }

        .status-display .status-icon {
            font-size: 2rem;
            flex-shrink: 0;
        }

        .status-display.status-success .status-icon {
            color: var(--success);
        }

        .status-display.status-warning .status-icon {
            color: var(--warning);
        }

        .status-content {
            flex: 1;
            text-align: left;
        }

        .status-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .status-display.status-success .status-title {
            color: var(--success-dark);
        }

        .status-display.status-warning .status-title {
            color: var(--warning-dark);
        }

        .status-date {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        /* Completion Progress */
        .completion-progress {
            margin-top: 1rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .progress-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        .progress-percentage {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--primary);
        }

        .progress-bar {
            height: 8px;
            background: var(--gray-200);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--success), var(--success-light));
            border-radius: 4px;
            transition: width 0.6s ease;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            border-radius: var(--radius);
            transition: var(--transition);
            cursor: pointer;
            white-space: nowrap;
            outline: none;
        }

        .btn:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), var(--warning-light));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, var(--warning-dark), var(--warning));
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), var(--danger-light));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, var(--danger-dark), var(--danger));
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: white;
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }

        .btn-secondary:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
            color: var(--gray-800);
        }

        .btn-action {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .btn-back {
            padding: 0.75rem 1.25rem;
            font-size: 0.875rem;
        }

        .w-100 {
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-container {
                padding: 1.5rem 1rem;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .sidebar-content {
                order: -1;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .quick-stats-grid {
                flex-direction: column;
                align-items: center;
            }

            .quick-stat {
                width: 100%;
                max-width: 200px;
                margin-bottom: 1rem;
            }

            .quick-stat:last-child {
                margin-bottom: 0;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1.5rem;
                padding: 1.5rem;
                text-align: center;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .project-hero {
                padding: 2rem 1.5rem;
            }

            .hero-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .project-status-icon {
                width: 4rem;
                height: 4rem;
                font-size: 1.75rem;
                align-self: center;
            }

            .project-title {
                font-size: 1.5rem;
            }

            .project-meta {
                flex-direction: column;
                gap: 0.75rem;
                align-items: center;
            }

            .hero-actions {
                justify-content: center;
                width: 100%;
                margin-top: 1rem;
            }

            .quick-stats-grid {
                flex-direction: row;
                justify-content: center;
            }

            .quick-stat {
                padding: 1rem;
                flex: 0 1 auto;
            }

            .quick-stat .stat-number {
                font-size: 1.5rem;
            }

            .quick-stat .stat-label {
                font-size: 0.75rem;
            }

            .section-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
                padding: 1.5rem;
            }

            .section-body {
                padding: 1.5rem;
            }

            .member-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
                padding: 1rem;
            }

            .document-item {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .document-preview {
                flex-direction: column;
                text-align: center;
            }

            .document-actions {
                justify-content: center;
            }

            .card-header {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
                padding: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .status-display {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }

            .status-content {
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 1rem 0.75rem;
            }

            .header-content,
            .project-hero {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .project-title {
                font-size: 1.25rem;
            }

            .project-status-icon {
                width: 3.5rem;
                height: 3.5rem;
                font-size: 1.5rem;
            }

            .hero-actions {
                margin-top: 0.5rem;
            }

            .quick-stats-grid {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .quick-stat {
                width: 100%;
                max-width: 200px;
                padding: 1rem;
                height: 120px;
                box-sizing: border-box;
                margin: 0;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .quick-stat .stat-number {
                font-size: 1.25rem;
            }

            .quick-stat .stat-label {
                font-size: 0.7rem;
            }

            .section-header,
            .section-body,
            .card-header,
            .card-body {
                padding: 1rem;
            }

            .member-documents {
                padding: 1rem;
            }

            .document-name {
                font-size: 0.8125rem;
            }

            .empty-documents {
                flex-direction: column;
                padding: 1.5rem 1rem;
            }
        }

        /* Focus and accessibility improvements */
        .btn:focus-visible,
        .btn-action:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn:disabled:hover {
            transform: none !important;
            box-shadow: var(--shadow-sm) !important;
        }

        /* Animation classes */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .slide-in-up {
            animation: slideInUp 0.5s ease-out;
        }

        /* Hover enhancements */
        .member-card:hover .member-avatar {
            transform: scale(1.1);
            box-shadow: var(--shadow-sm);
        }

        .info-card:hover .info-icon {
            transform: scale(1.1);
            color: var(--primary-light);
        }

        .quick-stat:hover .stat-number {
            color: var(--primary-light);
        }

        /* Print styles */
        @media print {
            .sidebar-content {
                display: none;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .btn,
            .btn-action {
                display: none;
            }

            .project-hero {
                background: white !important;
                border: 1px solid var(--gray-300);
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-container">
        <!-- Header Section -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-text">
                    <h1 class="page-title">Detail Proyek NDA</h1>
                    <p class="page-subtitle">Informasi lengkap dan terperinci tentang proyek beserta anggota tim dan berkas
                    </p>
                </div>
                <div class="header-action">
                    <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary btn-back">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Project Hero Banner (diperbaiki: hapus status NDA level proyek, fokus pada kesatuan per anggota) -->
        <div class="project-hero">
            <div class="hero-content">
                <div class="project-status-icon">
                    <i class="bi bi-folder-open"></i>
                </div>
                <div class="hero-details">
                    <h2 class="project-title">{{ $nda->project_name }}</h2>
                    <div class="project-meta">
                        <div class="meta-item">
                            <i class="bi bi-calendar-range me-2"></i>
                            @if ($nda->start_date && $nda->end_date)
                                {{ $nda->start_date->translatedFormat('d M Y') }} -
                                {{ $nda->end_date->translatedFormat('d M Y') }}
                            @else
                                Timeline belum diatur
                            @endif
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-people me-2"></i>
                            @php
                                $memberCount = 0;
                                if (is_array($nda->members)) {
                                    $memberCount = count($nda->members);
                                } elseif (is_string($nda->members) && json_decode($nda->members) !== null) {
                                    $memberCount = count(json_decode($nda->members, true));
                                }
                            @endphp
                            {{ $memberCount }} Anggota Tim
                        </div>
                    </div>
                </div>
                <div class="hero-actions">
                    <div class="quick-stats-grid">
                        <div class="quick-stat">
                            <div class="stat-number">{{ $nda->files->count() }}</div>
                            <div class="stat-label">Berkas</div>
                        </div>
                        <div class="quick-stat">
                            <div class="stat-number">
                                @if ($nda->formatted_duration)
                                    {{ explode(' ', $nda->formatted_duration)[0] }}
                                @else
                                    0
                                @endif
                            </div>
                            <div class="stat-label">
                                @if ($nda->formatted_duration && str_contains($nda->formatted_duration, 'hari'))
                                    Hari
                                @elseif ($nda->formatted_duration && str_contains($nda->formatted_duration, 'bulan'))
                                    Bulan
                                @else
                                    Hari
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-grid">
            <!-- Main Content -->
            <div class="main-content">
                <!-- Project Information Section (diperbaiki: hapus card Penandatanganan NDA level proyek) -->
                <div class="detail-section">
                    <div class="section-header">
                        <div class="section-icon section-icon-info">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <div class="section-content">
                            <h3 class="section-title">Informasi Proyek</h3>
                            <p class="section-description">Detail dan spesifikasi lengkap proyek</p>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="info-grid">
                            <div class="info-card col-span-2">
                                <div class="info-header">
                                    <i class="bi bi-folder info-icon"></i>
                                    <span class="info-label">Nama Proyek</span>
                                </div>
                                <div class="info-value">{{ $nda->project_name }}</div>
                            </div>
                            <div class="info-card col-span-2">
                                <div class="info-header">
                                    <i class="bi bi-text-paragraph info-icon"></i>
                                    <span class="info-label">Deskripsi Proyek</span>
                                </div>
                                <div class="info-value">
                                    @if ($nda->description)
                                        {{ $nda->description }}
                                    @else
                                        <span class="text-muted">Tidak ada deskripsi</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-card">
                                <div class="info-header">
                                    <i class="bi bi-calendar-event info-icon"></i>
                                    <span class="info-label">Tanggal Mulai</span>
                                </div>
                                <div class="info-value">
                                    @if ($nda->start_date)
                                        {{ $nda->start_date->translatedFormat('d F Y') }}
                                    @else
                                        <span class="text-muted">Belum ditentukan</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-card">
                                <div class="info-header">
                                    <i class="bi bi-calendar-check info-icon"></i>
                                    <span class="info-label">Tanggal Berakhir</span>
                                </div>
                                <div class="info-value">
                                    @if ($nda->end_date)
                                        {{ $nda->end_date->translatedFormat('d F Y') }}
                                    @else
                                        <span class="text-muted">Belum ditentukan</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-card">
                                <div class="info-header">
                                    <i class="bi bi-clock info-icon"></i>
                                    <span class="info-label">Durasi Proyek</span>
                                </div>
                                <div class="info-value">
                                    @if ($nda->formatted_duration)
                                        {{ $nda->formatted_duration }}
                                    @else
                                        <span class="text-muted">Belum dihitung</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Members Section (diperbaiki: status NDA berdasarkan signature_date per anggota) -->
                <div class="detail-section">
                    <div class="section-header">
                        <div class="section-icon section-icon-primary">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="section-content">
                            <h3 class="section-title">Anggota Tim & Berkas NDA</h3>
                            <p class="section-description">{{ $memberCount }} anggota terlibat dalam proyek ini</p>
                        </div>
                    </div>
                    <div class="section-body">
                        @php
                            $members = [];
                            if (is_array($nda->members)) {
                                $members = array_map(function ($member) {
                                    return is_array($member) && isset($member['name']) ? $member['name'] : $member;
                                }, $nda->members);
                            } elseif (is_string($nda->members) && json_decode($nda->members) !== null) {
                                $members = array_map(function ($member) {
                                    return is_array($member) && isset($member['name']) ? $member['name'] : $member;
                                }, json_decode($nda->members, true));
                            }
                        @endphp
                        @if (!empty($members))
                            <div class="members-grid">
                                @foreach ($members as $index => $member)
                                    @php
                                        $memberFiles = $nda->files->filter(function ($file) use ($member, $index) {
                                            return (isset($file->member_name) && $file->member_name === $member) ||
                                                (isset($file->member_index) && $file->member_index === $index) ||
                                                str_contains(
                                                    strtolower($file->file_path),
                                                    strtolower(str_replace(' ', '_', $member)),
                                                );
                                        });
                                        $isSigned = $memberFiles->every(fn($file) => $file->signature_date !== null);
                                        $firstSignatureDate = $memberFiles->whereNotNull('signature_date')->first()
                                            ?->signature_date;
                                    @endphp
                                    <div class="member-card">
                                        <div class="member-header">
                                            <div class="member-avatar">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div class="member-info">
                                                <h4 class="member-name">{{ $member }}</h4>
                                                <p class="member-role">Anggota Tim {{ $index + 1 }}</p>
                                            </div>
                                            <div class="member-status">
                                                @if ($isSigned && $memberFiles->count() > 0)
                                                    <div class="status-badge status-success">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Ditandatangani
                                                        ({{ $firstSignatureDate?->translatedFormat('d F Y') ?? 'Tidak diketahui' }})
                                                    </div>
                                                @else
                                                    <div class="status-badge status-warning">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        Belum Ditandatangani
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="member-documents">
                                            @if ($memberFiles->count() > 0)
                                                <div class="documents-list">
                                                    @foreach ($memberFiles as $file)
                                                        <div class="document-item">
                                                            <div class="document-preview">
                                                                <div class="document-icon">
                                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                                </div>
                                                                <div class="document-details">
                                                                    <div class="document-name">
                                                                        {{ basename($file->file_path) }}</div>
                                                                    <div class="document-meta">
                                                                        <span class="upload-date">
                                                                            <i class="bi bi-calendar3 me-1"></i>
                                                                            {{ $file->created_at ? $file->created_at->translatedFormat('d M Y') : 'Tidak diketahui' }}
                                                                        </span>
                                                                        @if ($file->signature_date)
                                                                            <span class="upload-date">
                                                                                <i class="bi bi-check-circle me-1"></i>
                                                                                Ditandatangani:
                                                                                {{ $file->signature_date->translatedFormat('d M Y') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="document-actions">
                                                                <a href="{{ Storage::url($file->file_path) }}"
                                                                    target="_blank" class="btn-action btn-view"
                                                                    title="Lihat Berkas">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="empty-documents">
                                                    <div class="empty-icon">
                                                        <i class="bi bi-file-earmark-x"></i>
                                                    </div>
                                                    <div class="empty-text">
                                                        <div class="empty-title">Belum ada berkas NDA</div>
                                                        <div class="empty-subtitle">{{ $member }} belum mengunggah
                                                            dokumen</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="empty-content">
                                    <h4 class="empty-title">Belum ada anggota tim</h4>
                                    <p class="empty-subtitle">Proyek ini belum memiliki anggota tim yang ditambahkan</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar (diperbaiki: status NDA berdasarkan semua anggota) -->
            <div class="sidebar-content">
                <!-- NDA Status Card -->
                <div class="sidebar-card">
                    <div class="card-header">
                        <div class="card-icon card-icon-success">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="card-title">
                            <h4>Status NDA</h4>
                            <p>Status penandatanganan dokumen</p>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $totalMembers = count($members);
                            $signedMembers = $nda->files
                                ->filter(fn($file) => $file->signature_date !== null)
                                ->unique('member_index') // Perbaikan: ganti dari 'member_name' ke 'member_index'
                                ->count();
                            $allSigned = $totalMembers > 0 && $signedMembers === $totalMembers;
                            $firstSignatureDate = $nda->files
                                ->whereNotNull('signature_date')
                                ->sortBy('signature_date')
                                ->first()?->signature_date;
                        @endphp
                        @if ($allSigned && $totalMembers > 0)
                            <div class="status-display status-success">
                                <div class="status-icon">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div class="status-content">
                                    <div class="status-title">Semua Ditandatangani</div>
                                    <div class="status-date">
                                        {{ $firstSignatureDate?->translatedFormat('d F Y') ?? 'Tidak diketahui' }}</div>
                                </div>
                            </div>
                        @else
                            <div class="status-display status-warning">
                                <div class="status-icon">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                                <div class="status-content">
                                    <div class="status-title">Menunggu ({{ $signedMembers }}/{{ $totalMembers }})</div>
                                    <div class="status-date">Penandatanganan belum lengkap</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistics Card (diperbaiki: persentase berdasarkan anggota yang ditandatangani) -->
                <div class="sidebar-card">
                    <div class="card-header">
                        <div class="card-icon card-icon-info">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="card-title">
                            <h4>Statistik Dokumen</h4>
                            <p>Ringkasan status berkas</p>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $totalMembers = count($members);
                            $membersWithDocs = $nda->files->groupBy('member_index')->count(); // Perbaikan: ganti dari 'member_name' ke 'member_index'
                            $completionPercentage = $totalMembers > 0 ? ($membersWithDocs / $totalMembers) * 100 : 0;
                        @endphp
                        <div class="completion-progress">
                            <div class="progress-header">
                                <span class="progress-label">Kelengkapan Berkas</span>
                                <span class="progress-percentage">{{ round($completionPercentage) }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $completionPercentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="sidebar-card">
                    <div class="card-header">
                        <div class="card-icon card-icon-primary">
                            <i class="bi bi-lightning"></i>
                        </div>
                        <div class="card-title">
                            <h4>Tindakan Cepat</h4>
                            <p>Aksi yang dapat dilakukan</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            <a href="{{ route('pegawai.nda.edit', $nda) }}" class="btn btn-warning btn-action w-100">
                                <i class="bi bi-pencil-square me-2"></i>
                                Edit Proyek
                            </a>
                            <form action="{{ route('pegawai.nda.delete', $nda) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-action delete-single-btn w-100"
                                    data-project-name="{{ $nda->project_name }}">
                                    <i class="bi bi-trash me-2"></i>
                                    Hapus Proyek
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize animations
            initializeAnimations();
            // Setup delete functionality
            setupDeleteFunctionality();
            // Setup tooltips and interactions
            setupInteractions();

            function initializeAnimations() {
                const animateElements = document.querySelectorAll('.member-card, .info-card, .sidebar-card');

                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('slide-in-up');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });

                animateElements.forEach(el => {
                    observer.observe(el);
                });

                const progressFill = document.querySelector('.progress-fill');
                if (progressFill) {
                    setTimeout(() => {
                        progressFill.style.width = progressFill.style.width;
                    }, 500);
                }
            }

            function setupDeleteFunctionality() {
                document.querySelectorAll('.delete-single-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const projectName = this.dataset.projectName;
                        const form = this.closest('form');

                        Swal.fire({
                            title: 'Konfirmasi Hapus Proyek',
                            html: `
                                <div style="text-align: left; margin: 1rem 0;">
                                    <p>Anda akan menghapus proyek:</p>
                                    <p style="font-weight: 600; color: #374151; background: #f3f4f6; padding: 0.75rem; border-radius: 6px; margin: 0.5rem 0;">
                                        "${projectName}"
                                    </p>
                                    <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 1rem; margin-top: 1rem;">
                                        <p style="color: #92400e; font-size: 0.85rem; margin: 0;">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            <strong>Peringatan:</strong> Tindakan ini akan menghapus semua data proyek termasuk NDA, berkas, dan anggota tim secara permanen.
                                        </p>
                                    </div>
                                </div>
                            `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Hapus Proyek',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            customClass: {
                                popup: 'swal-modern-popup',
                                title: 'swal-modern-title',
                                htmlContainer: 'swal-modern-html',
                                confirmButton: 'swal-modern-confirm',
                                cancelButton: 'swal-modern-cancel'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Menghapus Proyek...',
                                    html: 'Mohon tunggu, sedang memproses penghapusan.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                                form.submit();
                            }
                        });
                    });
                });
            }

            function setupInteractions() {
                document.querySelectorAll('.document-item').forEach(item => {
                    item.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateX(4px)';
                    });
                    item.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateX(0)';
                    });
                });

                document.querySelectorAll('.btn-action').forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 150);
                    });
                });

                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    document.querySelectorAll('[title]').forEach(element => {
                        new bootstrap.Tooltip(element);
                    });
                }
            }

            document.querySelectorAll('a[href^="#"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const backButton = document.querySelector('.btn-back');
                    if (backButton && document.activeElement.tagName !== 'INPUT' && document.activeElement
                        .tagName !== 'TEXTAREA') {
                        window.location.href = backButton.href;
                    }
                }
            });

            document.querySelectorAll('a[target="_blank"]').forEach(link => {
                link.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (icon && icon.classList.contains('bi-eye')) {
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-arrow-clockwise');
                        icon.style.animation = 'spin 1s linear infinite';
                        setTimeout(() => {
                            icon.classList.remove('bi-arrow-clockwise');
                            icon.classList.add('bi-eye');
                            icon.style.animation = '';
                        }, 2000);
                    }
                });
            });
        });

        const swalStyles = document.createElement('style');
        swalStyles.innerHTML = `
            .swal-modern-popup {
                border-radius: 16px !important;
                padding: 0 !important;
                font-family: 'Inter', sans-serif !important;
            }
            .swal-modern-title {
                font-size: 1.25rem !important;
                font-weight: 700 !important;
                color: #1f2937 !important;
                margin-bottom: 0.5rem !important;
            }
            .swal-modern-html {
                margin: 0 !important;
                padding: 0 !important;
            }
            .swal-modern-confirm {
                border-radius: 8px !important;
                padding: 0.75rem 1.5rem !important;
                font-weight: 600 !important;
                font-size: 0.875rem !important;
            }
            .swal-modern-cancel {
                border-radius: 8px !important;
                padding: 0.75rem 1.5rem !important;
                font-weight: 600 !important;
                font-size: 0.875rem !important;
            }
            .swal2-actions {
                gap: 0.75rem !important;
                margin-top: 1.5rem !important;
            }
            .swal2-loader {
                border-color: #4f46e5 transparent #4f46e5 transparent !important;
            }
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(swalStyles);
    </script>
@endpush
