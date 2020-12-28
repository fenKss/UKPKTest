const $test = $(`#test`);
$test.tabs();

class Test {

  constructor (testId, token) {
    this.testId = testId;
    this.init.elements();
    this.init.listeners();
    this.init.vars();
    this.token = token;
  }

  init = {
    elements : () => {
      this.$root = $(`#test`);
      if (!this.$root.length) {
        throw new Error('Root not found');
      }

      this.$questions = this.$root.find(`ul.questions`);
      if (!this.$questions.length) {
        throw new Error('Questions ul not found');
      }
      this.$tabs = this.$root.find(`div.tab-content`);
      if (!this.$tabs.length) {
        throw new Error('Tabs not found');
      }
    },
    vars     : () => {
      this.url = this.generateBaseUrl();
      this.apiUrl = this.url + `/api/test/${this.testId}/`;
      this.answers = {};
      this.answer(this.$tabs.find('.tab form'));
    },
    listeners: () => {
      const self = this;
      $(document).on('change', 'form[name="answer"]', (e) =>  {
        const $this   = $(e.currentTarget),
              $target = $(e.target);
        self.answer($this);

        const $tab = this.$tabs.find(`input[value="${$target.val()}"]`)
                         .closest(`[data-question-id]`);
        const questionId = $tab.attr(`data-question-id`);
        const $li = this.$questions.find(
          `li[data-question-id=${questionId}]`);
        if ($tab.find(`input:checked`).length) {
          $li.addClass('answered');
        } else {
          $li.removeClass('answered');
        }
      });

    },
  };

  api = {
    request: async (url, data = [], method = 'GET') => {
      const settings = {
        method,
      };
      if (method.toLowerCase() === 'post') {
        function getFormData (object) {
          const formData = new FormData(this);
          for (const key in object) {
            if (object.hasOwnProperty(key)){
              formData.append(key, object[key]);
            }
          }
          return formData;
        }

        settings['body'] = getFormData(data);

      } else if (method.toLowerCase() === 'get') {
        url = new URL(url);
        for (let key in data) {
          url.searchParams.append(key, data[key]);
        }
        settings.headers = {
          'Content-Type': 'application/json;charset=utf-8',
        };
      }

      const response = await fetch(url, settings);

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
        throw new Error(
          `Request error ` + (response.statusText || response.status));
      }
    },
      answer: () => {
        let url = this.apiUrl + `answer`;
        this.api.request(url, {'answers':JSON.stringify(this.answers), '_token':this.token}, 'post')
            .then(data => {
            console.log(data);
            })
            .catch(e => {throw e;});

      },
  };
  answer = ($form) => {
    $form.each((i, form) => {
      const $form      = $(form),
            questionId = $form.find(`input[name="question_id"]`).val(),
            inputs     = $form.find('input:checked');
      this.answers[questionId] = [];
      inputs.each((i, input) => {
        const $input = $(input);
        const value = parseInt($input.val());
        this.answers[questionId].push(value);
      });
    });
  };
  generateBaseUrl = () => {
    let baseUrl = window.location.protocol + '//' + window.location.hostname;
    if (window.location.port) baseUrl += ':' + window.location.port;
    return baseUrl;
  };
}
