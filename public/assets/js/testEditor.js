const testEditor = class {
  btn = {
    $addQuestion: null,
  };

  constructor () {
    this.init.elements();
    this.init.listeners();
    this.init.vars();
  }

  init = {
    elements : () => {
      this.$root = $(`#test-editor`);
      if (!this.$root.length) {
        throw new Error('Root not found');
      }

      this.$form = $(`#testEditorForm`);
      if (!this.$form.length) {
        throw new Error('Form not found');
      }

      this.$questions = this.$root.find('ul.questions');
      if (!this.$questions.length) {
        throw new Error('Questions ul not found');
      }
      this.$tabs = this.$root.find(`div.tab-content`);
      if (!this.$tabs.length) {
        throw new Error('Tabs not found');
      }
      this.btn.$addQuestion = $(`#add-question-btn`);
      if (!this.btn.$addQuestion.length) {
        throw new Error('Add question button not found');
      }
    },
    vars     : () => {
      this.url = this.generateBaseUrl();
      this.variantId = this.$form.find(`input[name="variant"]`).val();
      this.apiUrl = `/api/variant/${this.variantId}/`;
    },
    listeners: () => {
      this.btn.$addQuestion.click(async () => {
        this.api.question.add();
      });

      $(document).on('click', '.close', function () {
        $(this).closest(`form`).addClass('hidden');
      });
    },
  };
  api = {
    request : async (url, data = [], method = 'GET') => {
      const settings = {
        method,
        headers: {
          'Content-Type': 'application/json;charset=utf-8',
        },
      };
      if (method.toLowerCase() === 'post') {
        settings.body = JSON.stringify(data);
      }

      const response = await fetch(url);

      if (response.ok) {
        const text = await response.text();
        let json;
        try {
          json = JSON.parse(text);
        } catch (e) {
          return text;
        }
        if (json.error) {
          throw json.error_msg;
        } else {
          return json.data;
        }

      } else {
        throw response.error();
      }
    },
    question: {
      add: () => {
        let url = this.apiUrl + `question/add`;
        let questionId;
        this.api.request(url)
            .then(data => {
              return data.id;
            })
            .catch(e => {throw e;})
            .then(async id => {
              questionId = id;
              url = this.url +
                `/admin/variant/${this.variantId}/question/${questionId}`;
              return await this.api.request(url);
            })
            .then(data => {
              const $data = $(data),
                    $question = $data.find(`ul.questions li[data-question-id=${questionId}]`),
                    $tab = $data.find(`.tab[data-question-id=${questionId}]`);
              this.$questions.find(`li`).removeClass(`active`);
              this.$tabs.find(`.tab`).removeClass(`active`);
              $question.appendTo(this.$questions);
              $tab.appendTo(this.$tabs);


            })
            .catch(e => {throw e;});

      },
    },

  };
  form = {
    show: ($object) => {
      const pos = $object.offset();
      pos.top = pos.top + 10;
      pos.left = pos.left + 10;
      this.$form.removeClass('hidden').offset(pos);
    },
    hide: () => {
      this.$form.addClass('hidden');
    },
  };

  generateBaseUrl = () => {
    let baseUrl = window.location.protocol + '//' + window.location.hostname;
    if (window.location.port) baseUrl += ':' + window.location.port;
    return baseUrl;
  };
};