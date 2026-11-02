import pandas as pd
import joblib
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.model_selection import train_test_split
from sklearn.metrics import confusion_matrix

print("Loading dataset...")
df = pd.read_csv("dataset_ml_augmented.csv")
df = df.dropna()

X = df[['pillar', 'platform', 'posting_hour', 'hashtag_count', 'topic', 'script']]
y = df['label']

X_train, X_test, y_train, y_test = train_test_split(
    X,
    y,
    test_size=0.2,
    stratify=y,
    random_state=42
)

print("Loading model...")
pipeline = joblib.load("model_rf.pkl")

print("Predicting...")
y_pred = pipeline.predict(X_test)

print("Generating Confusion Matrix Plot...")
cm = confusion_matrix(y_test, y_pred)

plt.figure(figsize=(8, 6))
sns.heatmap(cm, annot=True, fmt='d', cmap='Blues', 
            xticklabels=pipeline.classes_, 
            yticklabels=pipeline.classes_)
plt.title('Confusion Matrix')
plt.ylabel('Actual Label')
plt.xlabel('Predicted Label')

plt.tight_layout()
plt.savefig('confusion_matrix_plot.png', dpi=300)
print("Saved confusion matrix plot to confusion_matrix_plot.png")
