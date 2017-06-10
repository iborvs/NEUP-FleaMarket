@extends('layout.master')

@section('title', "消息中心")

@section('content')

    <div id="message">
        {{--<a v-on:click="refreshContact">???</a>--}}
        <div class="row">
            <div class="column large-8 small-12">
                <message-dialog ref="messageDialog" v-on:top-contact="topContactCallback"></message-dialog>
            </div>
            <div class="column large-4 small-12">
                <contact-list ref="contactList" v-on:load-dialog="loadDialogCallback"></contact-list>
            </div>
        </div>
    </div>
    {{--<div class="page-content">
        @foreach($informations as $information)
            <form action="/message/{{$information->id}}" method="POST">
                {!! csrf_field() !!}
                {!! method_field('delete') !!}
                {{$information->id}}<br/>
                {{$information->title}}<br/>
                {{$information->content}}<br/>
                {{$information->created_at}}<br/>
                {{$information->is_read}}<br/>
                @if($information->sender_id != 0)
                    {{$information->receiver->nickname}}<br/>
                @else
                    系统通知<br/>
                @endif
                <input type="submit" value="Delete"><br/>
                <br/>
            </form>
        @endforeach
            {{ $informations->links() }}
    </div>--}}

    <script type="text/x-template" id="contact_list">
        <div>
            {{--<a v-on:click="getNewContact">###</a>--}}
            <p v-if="errorMessage">@{{ errorMessage }}</p>
            <ul>
                <table class="con-wrapper">
                    <li :class="{ con: true, active: current_contact_id === contact.contact_id }" v-for="(contact, index) in contacts" v-on:click="loadDialog(index)">
                        <tr>
                            <td>
                                <span>
                                    <img class="mavatar" :src="'/avatar/' + contact.contact_id + '/64/64'"/>
                                    <i v-if="contact.unread_count > 0" class="balloon-tip">@{{ contact.unread_count }}</i>
                                </span>
                            </td>
                            <td><p class="con-name">@{{ contact.contact.nickname }}</p></td>
                        </tr>
                    </li>
                </table>
            </ul>
            <a v-if="hasMore" v-on:click="getHistoryContact(false)">加载更多</a>
        </div>
    </script>

    <script type="text/x-template" id="message_dialog">
        <div :class="{ hide: isHidden }">
            <a v-if="hasMore" v-on:click="getHistoryMessage(0)">加载更多</a>
            <p v-else>没有更多了</p>
            <ul class="message-container">
                <li class="msg" v-for="message in messages">
                    <img class="mavatar" :src="'/avatar/' + message.sender_id + '/64/64'"/>
                    @{{ message.content }}
                </li>
            </ul>
            <p v-if="errorMessage">@{{ errorMessage }}</p>
            <textarea placeholder="键入要发送的内容:" v-model="inputMessage"></textarea>
            <input type="button" class="button" value="发送" v-on:click="sendMessage"/>
            <input id="token" type="hidden" value="{{ csrf_token() }}"/>
            {{--<a v-on:click="getNewMessage">!!!</a>--}}
        </div>
    </script>

    <script src="https://unpkg.com/vue@2.3.4/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="/js/message.js"></script>
    <link rel="stylesheet" href="/css/message.css"

@endsection