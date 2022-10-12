const rules = {
	require({ label }) {
		return v => !!v || `[${label}] 입력은 필수 입력입니다.`;
	},
}

//module.exports = rules;