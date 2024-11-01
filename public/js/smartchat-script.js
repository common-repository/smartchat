if (smartChatVisible.visible == 1) {
  var botao_av = document.createElement('a');
  botao_av.id = 'botao-smartchat';
  botao_av.classList.add('botao-smartchat');

  var icon = smartChatDataIcon.icon;
  botao_av.innerHTML = '<i class="smc-icon '+icon+'"></i>';

  var cor = smartChatDataCor.cor;
  botao_av.style.backgroundColor = cor;

  var boxchat_av = document.querySelector('#virtual-assistant-box');
  var chat_message = document.querySelector('.smc-chat-message');

  var position = smartChatDataPosition.position;
  switch (position) {
    case 'smc-inferior_direito':
      botao_av.classList.add('botao-smartchat-inferior-direito');
      boxchat_av.classList.add('smc-box-chat-inferior-direito');
      chat_message.classList.add('smc-bottom-chat');
      break;
    case 'smc-inferior_esquerdo':
      botao_av.classList.add('botao-smartchat-inferior-esquerdo');
      boxchat_av.classList.add('smc-box-chat-inferior-esquerdo');
	  chat_message.classList.add('smc-bottom-chat');
      break;
    case 'smc-superior_direito':
      botao_av.classList.add('botao-smartchat-superior-direito');
      boxchat_av.classList.add('smc-box-chat-superior-direito');
	  chat_message.classList.add('smc-top-chat');
      break;
    case 'smc-superior_esquerdo':
      botao_av.classList.add('botao-smartchat-superior-esquerdo');
      boxchat_av.classList.add('smc-box-chat-superior-esquerdo');
	  chat_message.classList.add('smc-top-chat');
      break;
    default:
      botao_av.classList.add('botao-smartchat-inferior-direito');
      boxchat_av.classList.add('smc-box-chat-inferior-direito');
	  chat_message.classList.add('smc-bottom-chat');
  }

  document.body.appendChild(botao_av);
}

jQuery(document).ready(function($) {
    $('.botao-smartchat').click(function() {
        if ($('.virtual-assistant-box').is(':visible')) {
            $('.virtual-assistant-box').fadeOut(100);
        } else {
            $('.virtual-assistant-box').fadeIn(100);
            $('#smc-message').focus();
            $('#virtual-assistant-box').scrollTop($('#virtual-assistant-box')[0].scrollHeight);
        }
    });
});