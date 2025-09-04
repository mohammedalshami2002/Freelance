@extends('layouts.master')

@section('title', trans('dashboard.chat') . ' | ' . $chat->user->name)

@section('css')
    <style>
        :root {
            --primary-color: #37A1D5;
            --primary-color-dark: #2F88B0;
            --sent-message-start: #37A1D5;
            --sent-message-end: #4BC9E6;
            --received-message-bg: #EFEFEF;
            --background-color: #F9F9F9;
            --text-color: #333;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--background-color);
        }

        .chat-messages-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 600px;
        }

        .chat-header {
            display: flex;
            align-items: center;
            padding-bottom: 15px;
            margin-bottom: 0px;
        }

        .chat-header .chat-avatar img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .chat-user-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 10px;
            scroll-behavior: smooth;
        }

        .chat-message {
            display: flex;
            margin-bottom: 15px;
            animation: fadeInUp 0.3s ease-in-out;
        }

        .message-sent {
            justify-content: flex-end;
        }

        .message-received {
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 65%;
            padding: 12px 18px;
            border-radius: 20px;
            font-size: 0.95rem;
            line-height: 1.4;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .message-sent .message-bubble {
            background: linear-gradient(135deg, var(--sent-message-start), var(--sent-message-end));
            color: #fff;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .message-received .message-bubble {
            background: var(--received-message-bg);
            color: var(--text-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .message-date {
            display: block;
            font-size: 0.7rem;
            color: #6c757d;
            margin-top: 5px;
            text-align: right;
        }

        .message-sent .message-date {
            text-align: left;
            color: rgba(255, 255, 255, 0.8);
        }

        .img-vid-show {
            max-width: 98%;
            border-radius: 12px;
        }

        .breadcrumb-header {
            background-color: #fff;
            border-radius: .25rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* ✅ إدخال جديد */
        .chat-input {
            padding: 12px 15px;
            border-top: 1px solid #eee;
            background: #fff;
            border-radius: 0 0 12px 12px;
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .chat-input .input-icons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .chat-input .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s ease;
            background: var(--received-message-bg);
            color: #777;
            flex-shrink: 0;
        }

        .chat-input .icon-btn:hover {
            background-color: #ddd;
        }

        .chat-input .icon-btn.active {
            background-color: var(--primary-color);
            color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .chat-input .form-control {
            border-radius: 50px;
            border: 1px solid #ccc;
            flex-grow: 1;
            min-width: 0;
            padding-left: 15px;
            height: 45px;
            transition: border-color 0.2s;
        }

        .chat-input .form-control:focus {
            border-color: var(--primary-color-dark);
            box-shadow: 0 0 0 0.2rem rgba(55, 161, 213, 0.25);
        }

        .chat-input button.send-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .chat-input button.send-btn:hover {
            background-color: var(--primary-color-dark);
            transform: scale(1.05);
        }

        /* ✅ فاصل */
        .chat-divider {
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, var(--sent-message-start), var(--primary-color), var(--received-message-bg));
            margin: 10px 0 20px 0;
            border-radius: 2px;
            opacity: 0.5;
        }

        /* ✅ Responsive */
        @media (max-width: 768px) {
            .chat-messages-container {
                padding: 10px;
            }

            .chat-header .chat-avatar img {
                width: 40px;
                height: 40px;
                margin-right: 10px;
            }

            .chat-user-name {
                font-size: 1.2rem;
            }

            .message-bubble {
                max-width: 85%;
                font-size: 0.9rem;
            }

            .chat-input {
                flex-direction: column;
                align-items: stretch;
            }

            .chat-input .input-icons {
                justify-content: center;
            }

            .chat-input form {
                width: 100%;
                margin-top: 10px;
            }
        }

        /* ✅ Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
                        <a
                            href="{{ $chat->user->type_user == 'service_provider' ? route('service_provider.dashboard') : route('Client.dashboard') }}">
                            {{ trans('dashboard.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('chat.index') }}">{{ trans('dashboard.chat_list') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $chat->user->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="chat-messages-container">
        <div class="chat-header">
            <div class="chat-avatar">
                <img src="{{ URL::asset('assets/image/Profile/' . $chat->user->image) }}" alt="{{ $chat->user->name }}">
            </div>
            <h5 class="chat-user-name p-1">{{ $chat->user->name }}</h5>
        </div>
        <div class="chat-divider"></div>

        <div class="chat-messages">
            @foreach ($chat->messages as $item)
                <div class="chat-message {{ $item->is_my_message ? 'message-sent' : 'message-received' }}">
                    <div class="message-bubble">
                        @if ($item->type == 1)
                            <p class="message-content">{{ $item->content }}</p>
                        @elseif ($item->type == 2)
                            <img src="{{ asset('uploads/messages/' . $item->content) }}" class="img-fluid img-vid-show">
                        @elseif ($item->type == 3)
                            <video controls class="video-fluid img-vid-show">
                                <source src="{{ asset('uploads/messages/' . $item->content) }}" type="video/mp4">
                            </video>
                        @elseif ($item->type == 4)
                            <audio controls>
                                <source src="{{ asset('uploads/messages/' . $item->content) }}" type="audio/mpeg">
                            </audio>
                        @elseif ($item->type == 5)
                            <div class="meeting-message">
                                <a href="{{ $item->content }}" target="_blank" rel="noopener noreferrer">
                                       {{ $item->content }}
                                </a>
                            </div>
                        @endif

                        <span class="message-date">{{ $item->date_for_humans }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="chat-input">
            <div class="input-icons">
                <button type="button" class="icon-btn active" data-type="1"><i class="fas fa-font"></i></button>
                <button type="button" class="icon-btn" data-type="2"><i class="fas fa-image"></i></button>
                <button type="button" class="icon-btn" data-type="3"><i class="fa fa-play"></i></button>
                <button type="button" class="icon-btn" data-type="4"><i class="fas fa-microphone"></i></button>
                <a href="{{ route('meetings.create', $chat->id) }}" class="icon-btn" alt="انشاء رابط مكالمة فيديو">
                    <i class="fas fa-video"></i>
                </a>
            </div>

            <form action="{{ route('chat.send', $chat->id) }}" method="POST" enctype="multipart/form-data" id="chatForm"
                class="d-flex flex-grow-1">
                @csrf
                <input type="hidden" name="type" id="messageType" value="1">
                <div class="flex-grow-1" id="inputContainer">
                    <input type="text" name="content" placeholder="{{ trans('dashboard.type_your_message') }}"
                        class="form-control" id="messageContent" required>
                </div>
                <button type="submit" class="send-btn"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.querySelector('.chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;

            const buttons = document.querySelectorAll('.icon-btn');
            const inputContainer = document.getElementById('inputContainer');
            const typeInput = document.getElementById('messageType');

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    buttons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    typeInput.value = this.dataset.type;

                    if (this.dataset.type === "1") {
                        inputContainer.innerHTML =
                            `<input type="text" name="content" placeholder="{{ trans('dashboard.type_your_message') }}" class="form-control" id="messageContent" required>`;
                    } else {
                        inputContainer.innerHTML =
                            `<input type="file" name="content" class="form-control" required>`;
                    }
                });
            });

            document.getElementById("chatForm").addEventListener("keydown", function(e) {
                if (e.key === "Enter" && typeInput.value == "1") {
                    e.preventDefault();
                    this.submit();
                }
            });
        });
    </script>
@endsection
