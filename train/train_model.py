import pandas as pd
import joblib

from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.preprocessing import OneHotEncoder
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics import (
    classification_report,
    accuracy_score,
    confusion_matrix
)

# ===================================
# LOAD DATASET
# ===================================
print("Loading dataset...")

df = pd.read_csv("dataset_ml_augmented.csv")

df = df.dropna()

print("Jumlah Data :", len(df))
print("\nDistribusi Label:")
print(df['label'].value_counts())

# ===================================
# FEATURE
# ===================================
X = df[
    [
        'pillar',
        'platform',
        'posting_hour',
        'hashtag_count',
        'topic',
        'script'
    ]
]

# ===================================
# TARGET
# ===================================
y = df['label']

# ===================================
# PREPROCESSING
# ===================================
preprocessor = ColumnTransformer(
    transformers=[

        # SCRIPT TF-IDF
        (
            'script_tfidf',
            TfidfVectorizer(
                max_features=300,
                ngram_range=(1, 2)
            ),
            'script'
        ),

        # TOPIC TF-IDF
        (
            'topic_tfidf',
            TfidfVectorizer(
                max_features=100,
                ngram_range=(1, 2)
            ),
            'topic'
        ),

        # CATEGORICAL
        (
            'categorical',
            OneHotEncoder(
                handle_unknown='ignore'
            ),
            [
                'pillar',
                'platform'
            ]
        ),

        # NUMERIC
        (
            'numeric',
            'passthrough',
            [
                'posting_hour',
                'hashtag_count'
            ]
        )
    ]
)

# ===================================
# RANDOM FOREST
# ===================================
rf = RandomForestClassifier(
    n_estimators=300,
    max_depth=15,
    class_weight='balanced',
    oob_score=True,
    random_state=42,
    n_jobs=-1
)

# ===================================
# PIPELINE
# ===================================
pipeline = Pipeline([
    ('preprocessor', preprocessor),
    ('model', rf)
])

# ===================================
# SPLIT DATA
# ===================================
X_train, X_test, y_train, y_test = train_test_split(
    X,
    y,
    test_size=0.2,
    stratify=y,
    random_state=42
)

print("\nTraining Data :", len(X_train))
print("Testing Data  :", len(X_test))

# ===================================
# TRAINING
# ===================================
print("\nTraining model...")

pipeline.fit(X_train, y_train)

# ===================================
# PREDIKSI
# ===================================
y_pred = pipeline.predict(X_test)

# ===================================
# EVALUASI
# ===================================
print("\n==============================")
print("HASIL EVALUASI MODEL")
print("==============================")

print("\nClassification Report:")
print(classification_report(y_test, y_pred))

accuracy = accuracy_score(y_test, y_pred)

print(
    "\nAccuracy:",
    round(accuracy * 100, 2),
    "%"
)

# ===================================
# CONFUSION MATRIX
# ===================================
print("\nConfusion Matrix:")

cm = confusion_matrix(
    y_test,
    y_pred
)

print(cm)

# ===================================
# OOB SCORE
# ===================================
oob_score = pipeline.named_steps[
    'model'
].oob_score_

print(
    "\nOOB Score:",
    round(oob_score * 100, 2),
    "%"
)

# ===================================
# FEATURE IMPORTANCE
# ===================================
print("\nTop 20 Feature Importance:")

try:

    feature_names = pipeline.named_steps[
        'preprocessor'
    ].get_feature_names_out()

    importances = pipeline.named_steps[
        'model'
    ].feature_importances_

    importance_df = pd.DataFrame({
        'feature': feature_names,
        'importance': importances
    })

    importance_df = (
        importance_df
        .sort_values(
            by='importance',
            ascending=False
        )
        .head(20)
    )

    print(importance_df)

except Exception as e:

    print(
        "Feature importance gagal ditampilkan:",
        e
    )

# ===================================
# SAVE MODEL
# ===================================
joblib.dump(
    pipeline,
    "model_rf.pkl"
)

print(
    "\n✅ Model berhasil disimpan ke model_rf.pkl"
)