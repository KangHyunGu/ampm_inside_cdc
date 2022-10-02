const rules = {
	min({ label, len = 3, info = null }) {
		return v => !!v ? v.length >= len || info || `[${label}] ${len}자 이상 입력하세요.` : true;
	},
	require({ label }) {
		return (v) => {
			let check = !!v
			if (v && typeof (v) == 'object' && !v.length) {
				//유튜브 태그 체크시
				check = false;
			}
			return check || `[${label}] 필수 입력입니다.`;
		}
	},

	imageRequired({ label }) {
		return (v) => {
			//0 ~ 9 인사이트 및 인스타이미지 필수 입력 체크
			let imgConfirm =
				vm.$data.form.cdc.is_insta == 'N' &&
					bo_table != 'insight'
					? true
					: false;
					
			if (!imgConfirm) {
				for (let idx = 0; idx < 10; idx++) {
					if (v[idx]) {
						imgConfirm = true;
						break;
					}
				}
			}
			return imgConfirm || `[${label}] 업로드는 최소 한장 필수 입력입니다.`
		}
	},

	videoRequired(val1, val2, clcd) {
		return () => {
			//동영상 15초 체크 X
			if (clcd == 'short') {
				return true;
			} else {
				return !!val1 || !!val2 || '영상링크 또는 파일업로드 둘 중 하나는 필수입니다.';
			}
		}
	},

	hashTagRules(field) {
		const hashChkCnt = field == 'wr_mhash' ? 3 : 7;
		const title = field == 'wr_mhash' ? '메인 해시태그' : '서브 해시태그'
		return (v) => {
			return v.length == 0 || v.length == hashChkCnt || `[${title}] 입력시 ${hashChkCnt}개 입력이 필수입니다.`
		}
	},

	alphaNum() {
		return v => !!v ? /^[a-zA-Z0-9_]+$/.test(v) || '영어와 숫자만 입력하세요.' : true;
	},
	pattern({ label, pattern, info = null }) {
		return v => !!v ? pattern.test(v) || info || `[${label}] 형식에 맞게 입력하세요` : true;
	},

	id(options) {
		const defaultOptions = {
			label: "아이디",
			len: 3,
			info: null,
			required: true
		};
		const opt = Object.assign(defaultOptions, options);
		const ruleArr = [];
		if (opt.required) {
			ruleArr.push(rules.require(opt));
		}
		ruleArr.push(rules.min(opt));
		ruleArr.push(rules.alphaNum());
		return ruleArr;
	},
	name(options) {
		const defaultOptions = {
			label: "이름",
			len: 2,
			info: null,
			required: true
		};
		const opt = Object.assign(defaultOptions, options);
		const ruleArr = [];
		if (opt.required) {
			ruleArr.push(rules.require(opt));
		}
		ruleArr.push(rules.min(opt));
		return ruleArr;
	},
	password(options) {
		const defaultOptions = {
			label: "비밀번호",
			info: null,
			required: true,
			len: 6,
			pattern: /^.*(?=^.{6,}$)(?=.*\d)(?=.*[a-zA-Z]).*$/
		};
		const opt = Object.assign(defaultOptions, options);
		const ruleArr = [];
		if (opt.required) {
			ruleArr.push(rules.require(opt));
		}
		ruleArr.push(rules.min(opt));
		ruleArr.push(rules.pattern(opt));
		return ruleArr;
	},
	email(options) {
		const defaultOptions = {
			label: "이메일",
			info: null,
			required: true,
			pattern: /.+@.+\..+/
		};
		const opt = Object.assign(defaultOptions, options);
		const ruleArr = [];
		if (opt.required) {
			ruleArr.push(rules.require(opt));
		}
		ruleArr.push(rules.pattern(opt));
		return ruleArr;
	},
	date(options) {
		const defaultOptions = {
			label: "날자",
			info: 'YYYY-MM-DD 형식에 맞게 입력하세요',
			required: true,
			pattern: /^\d{4}-\d{2}-\d{2}$/
		};
		const opt = Object.assign(defaultOptions, options);
		const ruleArr = [];
		if (opt.required) {
			ruleArr.push(rules.require(opt));
		}
		ruleArr.push(rules.pattern(opt));
		return ruleArr;
	},
	phone(options) {
		const defaultOptions = {
			label: "전화번호",
			info: null,
			required: true,
			pattern: /^(\d{2,3}-)?\d{3,4}-\d{4}$/
		};
		const opt = Object.assign(defaultOptions, options);
		const ruleArr = [];
		if (opt.required) {
			ruleArr.push(rules.require(opt));
		}
		ruleArr.push(rules.pattern(opt));
		return ruleArr;
	},

	chkVideo(val1, val2) {
		return () => {
			console.log(!!val1 || !!val2 || '필수 입력');
			return !!val1 || !!val2 || '필수 입력';
		}
	}
}

//module.exports = rules;