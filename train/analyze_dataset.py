import pandas as pd
import numpy as np

df = pd.read_csv(r"E:\BISMILLAH SKRIPSI DONE\train\dataset_ml (7).csv")

print("=" * 60)
print("1. INFORMASI UMUM DATASET")
print("=" * 60)
print(f"Jumlah baris  : {len(df)}")
print(f"Jumlah kolom  : {len(df.columns)}")
print(f"Kolom         : {list(df.columns)}")
print(f"\nTipe data per kolom:")
print(df.dtypes.to_string())

print("\n" + "=" * 60)
print("2. CEK MISSING VALUES (NULL)")
print("=" * 60)
missing = df.isnull().sum()
missing_pct = (df.isnull().sum() / len(df) * 100).round(2)
missing_df = pd.DataFrame({"Missing": missing, "Persen (%)": missing_pct})
print(missing_df.to_string())

print("\n" + "=" * 60)
print("3. CEK DUPLIKAT")
print("=" * 60)
print(f"Jumlah baris duplikat: {df.duplicated().sum()}")

print("\n" + "=" * 60)
print("4. DISTRIBUSI LABEL (TARGET)")
print("=" * 60)
if "label" in df.columns:
    label_counts = df["label"].value_counts()
    label_pct = (df["label"].value_counts(normalize=True) * 100).round(2)
    label_df = pd.DataFrame({"Count": label_counts, "Persen (%)": label_pct})
    print(label_df.to_string())
    print(f"\nJumlah kelas: {df['label'].nunique()}")
    print(f"Nilai unik   : {df['label'].unique()}")
else:
    print("Kolom 'label' tidak ditemukan!")

print("\n" + "=" * 60)
print("5. STATISTIK DESKRIPTIF (FITUR NUMERIK)")
print("=" * 60)
numeric_cols = df.select_dtypes(include=[np.number]).columns.tolist()
print(f"Kolom numerik: {numeric_cols}")
if numeric_cols:
    print(df[numeric_cols].describe().round(2).to_string())

print("\n" + "=" * 60)
print("6. NILAI UNIK KOLOM KATEGORIKAL")
print("=" * 60)
cat_cols = df.select_dtypes(include=["object"]).columns.tolist()
for col in cat_cols:
    unique_vals = df[col].nunique()
    print(f"\n  {col}: {unique_vals} nilai unik")
    if unique_vals <= 15:
        print(f"    -> {df[col].unique()}")

print("\n" + "=" * 60)
print("7. CEK NILAI NOL ATAU NEGATIF PADA FITUR NUMERIK")
print("=" * 60)
for col in numeric_cols:
    zero_count = (df[col] == 0).sum()
    neg_count = (df[col] < 0).sum()
    print(f"  {col}: zeros={zero_count}, negatives={neg_count}")

print("\n" + "=" * 60)
print("8. CEK OUTLIER (IQR METHOD)")
print("=" * 60)
for col in numeric_cols:
    Q1 = df[col].quantile(0.25)
    Q3 = df[col].quantile(0.75)
    IQR = Q3 - Q1
    lower = Q1 - 1.5 * IQR
    upper = Q3 + 1.5 * IQR
    outliers = ((df[col] < lower) | (df[col] > upper)).sum()
    print(f"  {col}: {outliers} outlier(s)  [range: {lower:.2f} - {upper:.2f}]")

print("\n" + "=" * 60)
print("9. CEK KORELASI ANTAR FITUR NUMERIK")
print("=" * 60)
if len(numeric_cols) > 1:
    corr = df[numeric_cols].corr().round(2)
    print(corr.to_string())

print("\n" + "=" * 60)
print("10. SAMPLE DATA (5 BARIS PERTAMA)")
print("=" * 60)
print(df.head().to_string())

print("\n" + "=" * 60)
print("RINGKASAN KESIAPAN DATASET")
print("=" * 60)
issues = []
if df.isnull().sum().sum() > 0:
    issues.append(f"- Ada {df.isnull().sum().sum()} missing values yang perlu ditangani")
if df.duplicated().sum() > 0:
    issues.append(f"- Ada {df.duplicated().sum()} baris duplikat")
if "label" in df.columns:
    ratio = label_counts.min() / label_counts.max()
    if ratio < 0.5:
        issues.append(f"- Label TIDAK SEIMBANG (rasio min/max = {ratio:.2f}). Pertimbangkan oversampling/undersampling")
for col in numeric_cols:
    Q1 = df[col].quantile(0.25)
    Q3 = df[col].quantile(0.75)
    IQR = Q3 - Q1
    outliers = ((df[col] < Q1 - 1.5 * IQR) | (df[col] > Q3 + 1.5 * IQR)).sum()
    if outliers > 0:
        issues.append(f"- Kolom '{col}' memiliki {outliers} outlier")

cat_features_for_encoding = [c for c in cat_cols if c != "label"]
if cat_features_for_encoding:
    issues.append(f"- Kolom kategorikal ({cat_features_for_encoding}) perlu di-encode (Label/One-Hot Encoding)")

if len(df) < 100:
    issues.append(f"- Jumlah data terlalu sedikit ({len(df)} baris). Pertimbangkan menambah data")

if issues:
    print("BELUM SIAP. Masalah yang ditemukan:")
    for i in issues:
        print(f"  {i}")
else:
    print("DATASET SIAP UNTUK DI-TRAIN!")
