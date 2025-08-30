@extends('layouts.master')

@section('title', trans('dashboard.chat'))

@section('css')
    <style>
        :root {
            --primary-color: #37A1D5;
            --background-color: #F8F9FA;
            --container-bg: #FFFFFF;
            --card-border-color: #E0E0E0;
            --text-color-primary: #343A40;
            --text-color-secondary: #6C757D;
            --hover-bg: #F5F5F5;
        }

        body {
            background-color: var(--background-color);
        }

        .chat-list-container {
            background-color: var(--container-bg);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .chat-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .chat-link {
            text-decoration: none;
            color: inherit;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid var(--card-border-color);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .chat-item:last-child {
            border-bottom: none;
        }

        .chat-item:hover {
            background-color: var(--hover-bg);
            transform: translateY(-2px);
        }

        .chat-avatar img {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--primary-color);
            padding: 2px;
        }

        .chat-details {
            flex-grow: 1;
            margin-left: 18px;
            min-width: 0;
        }

        .chat-user {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .user-name {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-color-primary);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .chat-date {
            font-size: 0.8rem;
            color: var(--text-color-secondary);
            flex-shrink: 0;
            margin-left: 10px;
        }

        .chat-message {
            margin: 5px 0 0;
            font-size: 0.9rem;
            color: var(--text-color-secondary);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .pagination-wrapper {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid var(--card-border-color);
        }

        .pagination-wrapper .pagination {
            justify-content: center;
        }

        .breadcrumb-header {
            background-color: #f8f9fa;
            border-radius: .25rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        /* ✅ New Styles for Empty State */
        .empty-chat-list {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-color-secondary);
            font-size: 1rem;
        }

        .empty-chat-list i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ADB5BD;
        }
    </style>

@endsection

@section('page-header')
    @include('meesage')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('service_provider.dashboard') }}">
                            {{ trans('dashboard.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.chat_list') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="chat-list-container">
        <ul class="chat-list">
            @forelse ($chats as $chat)
                <a href="{{ route('chat.show', ['chat' => $chat->id]) }}" class="chat-link">
                    <li class="chat-item">
                        <div class="chat-avatar">
                            <img src="{{ URL::asset('assets/image/Profile/' . $chat->user->image) }}"
                                alt="{{ $chat->user->name }}" class="rounded-circle m-1">
                        </div>
                        <div class="chat-details">
                            <div class="chat-user">
                                <h5 class="user-name">{{ $chat->user->name }}</h5>
                                <span class="chat-date">
                                    {{ $chat->last_message ? $chat->last_message->created_at->diffForHumans() : '' }}
                                </span>
                            </div>
                            <div class="chat-message">
                                <p>{{ $chat->last_message ? \Str::limit($chat->last_message->content, 50) : trans('dashboard.no_messages_available') }}
                                </p>
                            </div>
                        </div>
                    </li>
                </a>
            @empty
                <div class="empty-chat-list">
                    <i class="fas fa-comment-dots"></i>
                    <p>{{ trans('dashboard.no_chats_found') }}</p>
                </div>
            @endforelse
        </ul>
        <div class="pagination-wrapper">
            {{ $chats->links() }}
        </div>
    </div>

@endsection
