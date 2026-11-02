from flask import Flask, request, jsonify
import joblib
import pandas as pd

app = Flask(__name__)

# =========================
# LOAD MODEL
# =========================
model = joblib.load('model_rf.pkl')


@app.route('/')
def home():
    return "AI Recommendation API Running 🚀"


@app.route('/predict', methods=['POST'])
def predict():
    try:

        data = request.json

        # =========================
        # VALIDASI
        # =========================
        required_fields = [
            'platform',
            'posting_hour',
            'hashtag_count',
            'pillar',
            'topic',
            'title',
            'script'
        ]

        missing = [
            field for field in required_fields
            if field not in data
        ]

        if missing:
            return jsonify({
                "status": "error",
                "message": f"Field tidak lengkap: {', '.join(missing)}"
            }), 400

        # =========================
        # DATAFRAME
        # =========================
        df = pd.DataFrame([{
            'platform': str(data['platform']),
            'posting_hour': int(data['posting_hour']),
            'hashtag_count': int(data['hashtag_count']),
            'pillar': str(data['pillar']),
            'topic': str(data['topic']),
            'title': str(data['title']),
            'script': str(data['script'])
        }])

        # =========================
        # PREDICT
        # =========================
        prediction = model.predict(df)[0]

        # =========================
        # CONFIDENCE
        # =========================
        confidence = None

        try:
            confidence = round(
                model.predict_proba(df)[0].max() * 100,
                2
            )
        except:
            pass

        return jsonify({
            "status": "success",
            "prediction": prediction,
            "confidence": confidence
        })

    except Exception as e:

        return jsonify({
            "status": "error",
            "message": str(e)
        }), 500


if __name__ == '__main__':
    app.run(
        host='0.0.0.0',
        port=5000,
        debug=True
    )