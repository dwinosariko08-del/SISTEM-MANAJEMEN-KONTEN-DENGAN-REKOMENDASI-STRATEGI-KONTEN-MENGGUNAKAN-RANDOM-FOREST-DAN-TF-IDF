import joblib
import pandas as pd

model = joblib.load('model_rf.pkl')

data = pd.DataFrame([{
    'pillar': 'Problem Solving',
    'platform': 'instagram',
    'posting_hour': 20,
    'hashtag_count': 5,
    'topic': 'Cara Menghilangkan Gema di Kamar Tanpa Renovasi Mahal'
}])

result = model.predict(data)

confidence = model.predict_proba(data)[0].max() * 100

print("Prediksi :", result[0])
print("Confidence :", round(confidence, 2), "%")