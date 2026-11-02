from http.server import BaseHTTPRequestHandler
import json
import os
import joblib
import pandas as pd

# =========================
# LOAD MODEL (cold start)
# =========================
MODEL_PATH = os.path.join(os.path.dirname(__file__), '..', 'model_rf.pkl')
model = joblib.load(MODEL_PATH)


class handler(BaseHTTPRequestHandler):

    def do_GET(self):
        self.send_response(200)
        self.send_header('Content-Type', 'application/json')
        self.send_header('Access-Control-Allow-Origin', '*')
        self.end_headers()
        self.wfile.write(
            json.dumps({"status": "ok", "message": "AI Recommendation API Running 🚀"}).encode()
        )

    def do_POST(self):
        try:
            content_length = int(self.headers.get('Content-Length', 0))
            body = self.rfile.read(content_length)
            data = json.loads(body)

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
                self.send_response(400)
                self.send_header('Content-Type', 'application/json')
                self.send_header('Access-Control-Allow-Origin', '*')
                self.end_headers()
                self.wfile.write(
                    json.dumps({
                        "status": "error",
                        "message": f"Field tidak lengkap: {', '.join(missing)}"
                    }).encode()
                )
                return

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

            self.send_response(200)
            self.send_header('Content-Type', 'application/json')
            self.send_header('Access-Control-Allow-Origin', '*')
            self.end_headers()
            self.wfile.write(
                json.dumps({
                    "status": "success",
                    "prediction": prediction,
                    "confidence": confidence
                }).encode()
            )

        except Exception as e:
            self.send_response(500)
            self.send_header('Content-Type', 'application/json')
            self.send_header('Access-Control-Allow-Origin', '*')
            self.end_headers()
            self.wfile.write(
                json.dumps({
                    "status": "error",
                    "message": str(e)
                }).encode()
            )

    def do_OPTIONS(self):
        """Handle CORS preflight requests"""
        self.send_response(200)
        self.send_header('Access-Control-Allow-Origin', '*')
        self.send_header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        self.send_header('Access-Control-Allow-Headers', 'Content-Type')
        self.end_headers()

