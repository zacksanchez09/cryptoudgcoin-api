# -*- coding: utf-8-*-

import urllib.request
import numpy as np
import matplotlib.pyplot as plt
import yaml
import time
import math
import pandas as pd
import json
from sklearn.utils import shuffle
from sklearn.cluster import KMeans
from sklearn.preprocessing import LabelEncoder
from sklearn.preprocessing import MinMaxScaler

class Application:
  vallist = []
  def __init__(self):
    #API URL
    base_url = 'https://cryptoudgcoin.com/api/v1/'
    #API Endpoints
    endpoints = ["users", "wallets", "history"]

    with urllib.request.urlopen(base_url + "users") as url:
      data_Users = url.read()
      df_Users = pd.read_json(data_Users)
      df_Users = df_Users.drop(['name', 'last_name', 'email_verified_at', 'conekta_customer_id', 'created_at', 'updated_at','nip', 'phone', 'email', 'udg_code'], axis=1)
      df_Users = df_Users.sort_values(by='id')
      df_Users = df_Users.reset_index()
      df_Users = df_Users.drop(['index'], axis=1)

      # print(df_Users)
    with urllib.request.urlopen(base_url + "wallets") as url:
      data_Wallets = url.read()
      df_Wallets = pd.read_json(data_Wallets)
      df_Wallets = df_Wallets.drop(['id', 'description', 'created_at', 'updated_at', 'decimal_places', 'holder_type'], axis=1)
      df_Wallets['balance_UDGC'] = df_Wallets.apply(self.udgcBalance, axis=1)
      df_Wallets['balance_MXN'] = df_Wallets.apply(self.mxnBalance, axis=1)
      df_Wallets = df_Wallets.replace('None','').groupby('holder_id',as_index=False).agg('sum')
      df_Wallets = df_Wallets.rename(columns={"balance": "balance_Total"})
      df_Wallets['balance_Total'] = df_Wallets['balance_Total'].astype(float)
      pd.set_option("display.max_rows", None, "display.max_columns", None)

      balanceTotal = df_Wallets['balance_Total']
      max_value = balanceTotal.max()

    with urllib.request.urlopen(base_url + "history") as url:
      data_History = url.read()
      df_History = pd.read_json(data_History)
      df_History = df_History.drop(['payable_type', 'meta', 'created_at', 'updated_at', 'confirmed', 'uuid'], axis=1)
      df_History = df_History.dropna()

      # print(df_History)

      df_Total = pd.concat([df_Wallets, df_Users], axis = 1)
      df_Total = df_Total.drop(['id', 'holder_id'], axis = 1)
      # print(df_Total)

      x = df_Total
      y = df_Total['career']

      le = LabelEncoder()
      x['career'] = le.fit_transform(x['career'])
      y = le.transform(y)

      cols = x.columns
      ms = MinMaxScaler()

      x = ms.fit_transform(x)
      x = pd.DataFrame(x, columns=[cols])

      kmeans = KMeans(n_clusters=6,random_state=0)

      kmeans.fit(x)

      labels = kmeans.labels_

      # check how many of the samples were correctly labeled
      correct_labels = sum(y == labels)

      print(correct_labels)

      cs = []

      # kmeans = KMeans(n_clusters=8,random_state=0)

      # kmeans.fit(x)

      # labels = kmeans.labels_
      # # check how many of the samples were correctly labeled
      # correct_labels = sum(y == labels)

      cs = df_History

      cs_two = df_Total
      # N = 51
      # for i in range(1, N):
      #   kmeans = KMeans(n_clusters = i, init = 'k-means++', max_iter = 300, n_init = 10, random_state = 0)
      #   kmeans.fit(x)
      #   cs = (kmeans.inertia_)
      # cs = (np.random.rand(N))

      # x = pd.concat([df_Wallets], axis = 1)
      # x = x.drop(['balance_MXN', 'balance_UDGC'], axis = 1)

      # n = df_Total
      # m = df_Total['balance_Total']

      # le = LabelEncoder()
      # n['balance_Total'] = le.fit_transform(n['balance_Total'])
      # m = le.transform(m)

      # cols = n.columns
      # ms = MinMaxScaler()

      # n = ms.fit_transform(n)
      # n = pd.DataFrame(n, columns=[cols])

      # kmeans_two = KMeans(n_clusters=8,random_state=0)

      # kmeans_two.fit(n)

      # N = 51
      # for i in range(1, N):
      #   kmeans_two = KMeans(n_clusters = i, init = 'k-means++', max_iter = 300, n_init = 10, random_state = 0)
      #   kmeans_two.fit(n)
      #   cs_two = (kmeans_two.inertia)
      # cs_two = (np.random.rand(N))

      total_users = len(df_Users)
      total_wallets = len(df_Wallets)
      total_transactions = len(df_History)

      U = total_users
      W = total_wallets
      T = total_transactions
      # g1 = (total_users * np.random.rand(W), np.random.rand(U))
      g2 = (total_wallets * np.random.rand(T), max_value * np.random.rand(T))
      g3 = (total_wallets * np.random.rand(W), max_value * np.random.rand(W))

      data = (g2, g3)

      colors = ("red", "green")
      groups = ("UDGC", "MXN")

      # Create plot
      fig = plt.figure()
      ax = fig.add_subplot(1, 1, 1)

      for data, color, group in zip(data, colors, groups):
        x, y = data
        ax.scatter(x, y, alpha=0.8, c=color, edgecolors='none', s=30, label=group)

      plt.title('CryptoUDGCoin Scatter Plot')
      plt.legend(loc=2)
      plt.xlabel('Numero de Carteras')
      plt.ylabel('Valor Combinado')
      plt.savefig('plots/scatter.png')

  def udgcBalance(self, row):
    if row['slug'] == 'udgc_wallet':
      val = row['balance']
    else:
      val = None
    return val

  def mxnBalance(self, row):
    if row['slug'] == 'mxn_wallet':
      val = row['balance']
    else:
      val = None
    return val

application = Application()
